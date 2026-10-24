<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Profile;

use Illuminate\Support\Facades\Cache;
use App\Models\Kategori;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        
        // Fix for local Windows SSL error when uploading to Cloudinary
        if (file_exists(base_path('cacert.pem'))) {
            putenv('CURL_CA_BUNDLE=' . base_path('cacert.pem'));
        }

        // Enforce HTTPS for routes, assets, and URLs when running in production or behind HTTPS proxy
        if ($this->app->environment('production') || env('APP_ENV') === 'production' || request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share profileData & kategoris efficiently with file caching
        View::composer(['layouts.guest', 'layouts.app', 'layouts.partials.topbar-lading'], function ($view) {
            $sharedProfile = Cache::remember('site_profile', 3600, function () {
                try {
                    return Profile::first();
                } catch (\Throwable $e) {
                    return null;
                }
            });

            $sharedKategoris = Cache::remember('site_kategoris', 3600, function () {
                try {
                    return Kategori::all();
                } catch (\Throwable $e) {
                    return collect();
                }
            });

            $view->with('profileData', $sharedProfile);
            $view->with('kategoris', $sharedKategoris);
        });
    }
}

if (!function_exists('cloudinary_url')) {
    function cloudinary_url($path, $transformations = 'f_webp,q_auto') {
        if (!$path) return '';
        $trans = $transformations ? trim($transformations, '/') : 'f_webp,q_auto';
        $trans = str_replace('f_auto', 'f_webp', $trans);

        // Jika path sudah berupa URL Cloudinary lengkap (misal tersimpan di DB)
        if (str_contains($path, 'res.cloudinary.com')) {
            if (preg_match('#/image/upload/(?:([a-zA-Z0-9_,]+)/)?(.*)$#', $path, $matches)) {
                $firstSegment = $matches[1] ?? '';
                // Jika sudah ada segment transformasi (mengandung _ atau ,)
                if ($firstSegment && (str_contains($firstSegment, '_') || str_contains($firstSegment, ','))) {
                    return preg_replace('#/image/upload/[^/]+/#', '/image/upload/' . $trans . '/', $path, 1);
                } else {
                    return preg_replace('#/image/upload/#', '/image/upload/' . $trans . '/', $path, 1);
                }
            }
            return $path;
        }

        // Jika URL eksternal http/https non-Cloudinary
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $cloudName = config('services.cloudinary.cloud_name') ?: env('EXTERNAL_S3_CLOUDINARY_NAME', 'wetpkzmj');
        $cleanPath = ltrim($path, '/');
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$trans}/{$cleanPath}";
    }
}

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
    function cloudinary_url($path, $transformations = 'f_auto,q_auto') {
        if (!$path) return '';
        if (str_starts_with($path, 'http')) return $path;
        $cloudName = config('services.cloudinary.cloud_name') ?: env('EXTERNAL_S3_CLOUDINARY_NAME', 'wetpkzmj');
        $trans = $transformations ? rtrim($transformations, '/') . '/' : '';
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$trans}{$path}";
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Profile;

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

        // Share profileData to guest & admin layouts efficiently
        View::composer(['layouts.guest', 'layouts.app', 'layouts.partials.topbar-lading'], function ($view) {
            static $sharedProfile = false;
            if ($sharedProfile === false) {
                try {
                    $sharedProfile = Schema::hasTable('profiles') ? Profile::first() : null;
                } catch (\Throwable $e) {
                    $sharedProfile = null;
                }
            }
            $view->with('profileData', $sharedProfile);
        });
    }
}

if (!function_exists('cloudinary_url')) {
    function cloudinary_url($path) {
        if (!$path) return '';
        if (str_starts_with($path, 'http')) return $path;
        $cloudName = config('services.cloudinary.cloud_name') ?: env('EXTERNAL_S3_CLOUDINARY_NAME', 'wetpkzmj');
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$path}";
    }
}

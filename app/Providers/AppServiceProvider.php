<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
    }
}

if (!function_exists('cloudinary_url')) {
    function cloudinary_url($path) {
        if (!$path) return '';
        if (str_starts_with($path, 'http')) return $path;
        $cloudName = env('EXTERNAL_S3_CLOUDINARY_NAME', 'wetpkzmj'); // fallback ke cloud_name user
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$path}";
    }
}

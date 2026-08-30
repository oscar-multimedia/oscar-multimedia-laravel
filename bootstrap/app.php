<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

if (!function_exists('cloudinary_url')) {
    function cloudinary_url($path) {
        if (!$path) return '';
        if (str_starts_with($path, 'http')) return $path;
        $cloudName = env('EXTERNAL_S3_CLOUDINARY_NAME', 'wetpkzmj');
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$path}";
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

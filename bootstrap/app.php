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

$app = Application::configure(basePath: dirname(__DIR__))
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

// Vercel read-only filesystem fix
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    // Suppress PHP 8.4+ deprecation warnings to prevent HTTP 500
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

    $app->useStoragePath('/tmp/storage');
    
    $_SERVER['APP_SERVICES_CACHE'] = '/tmp/services.php';
    $_SERVER['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
    $_SERVER['APP_CONFIG_CACHE'] = '/tmp/config.php';
    $_SERVER['APP_ROUTES_CACHE'] = '/tmp/routes.php';
    $_SERVER['APP_EVENTS_CACHE'] = '/tmp/events.php';
    $_SERVER['VIEW_COMPILED_PATH'] = '/tmp/views';
    $_SERVER['CACHE_STORE'] = 'array'; // Hindari menulis ke file cache
    $_SERVER['SESSION_DRIVER'] = 'cookie'; // Hindari menulis file session
    $_SERVER['LOG_CHANNEL'] = 'stderr'; // Log ke Vercel console, bukan file

    // Foolproof TiDB SSL Fix: Download fresh CA with UNIX line endings to /tmp
    $caPath = '/tmp/cacert.pem';
    if (!file_exists($caPath)) {
        $caContent = file_get_contents('https://curl.se/ca/cacert.pem');
        file_put_contents($caPath, $caContent);
    }
    $_SERVER['MYSQL_ATTR_SSL_CA'] = $caPath;
    $_ENV['MYSQL_ATTR_SSL_CA'] = $caPath;
}

return $app;

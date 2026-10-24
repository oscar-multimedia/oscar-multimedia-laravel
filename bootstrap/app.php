<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

if (!function_exists('cloudinary_url')) {
    function cloudinary_url($path, $transformations = 'f_webp,q_auto:eco') {
        if (!$path) return '';
        $trans = $transformations ? trim($transformations, '/') : 'f_webp,q_auto:eco';
        $trans = str_replace('f_auto', 'f_webp', $trans);
        if (str_contains($trans, 'q_auto') && !str_contains($trans, 'q_auto:')) {
            $trans = str_replace('q_auto', 'q_auto:eco', $trans);
        }

        // Jika path sudah berupa URL Cloudinary lengkap (misal tersimpan di DB)
        if (str_contains($path, 'res.cloudinary.com')) {
            if (preg_match('#/image/upload/(?:([a-zA-Z0-9_,:]+)/)?(.*)$#', $path, $matches)) {
                $firstSegment = $matches[1] ?? '';
                // Jika sudah ada segment transformasi (mengandung _ atau , atau :)
                if ($firstSegment && (str_contains($firstSegment, '_') || str_contains($firstSegment, ',') || str_contains($firstSegment, ':'))) {
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

        try {
            $cloudName = config('services.cloudinary.cloud_name') ?: env('EXTERNAL_S3_CLOUDINARY_NAME', 'wetpkzmj');
        } catch (\Throwable $e) {
            $cloudName = env('EXTERNAL_S3_CLOUDINARY_NAME', 'wetpkzmj');
        }
        $cleanPath = ltrim($path, '/');
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$trans}/{$cleanPath}";
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

    // Gunakan CA bundle bawaan sistem Linux Vercel (sudah pasti ada)
    putenv('MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt');
    $_ENV['MYSQL_ATTR_SSL_CA'] = '/etc/ssl/certs/ca-certificates.crt';
}

return $app;

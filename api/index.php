<?php

// Suppress PHP 8.4+ deprecation warnings on Vercel
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Fix TiDB SSL BEFORE Laravel boots (env() reads from $_ENV)
// Vercel server is Linux, so we use the native CA bundle
$caPath = '/etc/ssl/certs/ca-certificates.crt';
if (!file_exists($caPath)) {
    $caPath = '/etc/pki/tls/certs/ca-bundle.crt';
}
if (!file_exists($caPath)) {
    // Fallback: download sertifikat segar ke /tmp
    $caPath = '/tmp/cacert.pem';
    if (!file_exists($caPath)) {
        file_put_contents($caPath, file_get_contents('https://curl.se/ca/cacert.pem'));
    }
}

// Set SEBELUM Laravel memuat config/database.php
putenv("MYSQL_ATTR_SSL_CA={$caPath}");
$_ENV['MYSQL_ATTR_SSL_CA'] = $caPath;
$_SERVER['MYSQL_ATTR_SSL_CA'] = $caPath;

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';

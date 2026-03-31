<?php
// Sembunyikan pesan deprecation PHP 8.5 bawaan server Vercel agar tidak merusak tampilan HTML
error_reporting(E_ALL);
ini_set('display_errors', '1');

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Tangani Vercel Read-Only File System dengan mengalihkan storage ke folder /tmp
$directories = [
    '/tmp/storage/app',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

// 2. Load autoload & bootstrap
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

// 3. Wajibkan Laravel menggunakan storage di /tmp
$app->useStoragePath('/tmp/storage');

// 4. Proses request HTML
$app->handleRequest(Request::capture());

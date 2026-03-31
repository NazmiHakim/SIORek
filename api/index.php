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

// 2. Load autoload
require __DIR__.'/../vendor/autoload.php';

// 3. Catch early errors during bootstrap
try {
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // Wajibkan Laravel menggunakan storage di /tmp
    $app->useStoragePath('/tmp/storage');
    
    // 4. Proses request HTML
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    // Jika gagal di sini (sebelum View Service boot), tampilkan error mentah
    echo "<h1>Laravel Bootstrap Error</h1>";
    echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    exit(1);
}

<?php
// Sembunyikan pesan deprecation PHP 8.5 bawaan server Vercel agar tidak merusak tampilan HTML
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '0');

require __DIR__ . '/../public/index.php';

<?php
define('LARAVEL_START', microtime(true));
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$start = microtime(true);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/', 'GET')
);
$time = microtime(true) - $start;

echo "\nDone in $time seconds\n";

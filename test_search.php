<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
print_r(app(\App\Services\SmartSearchService::class)->search('berita yang di tulis oleh zainal'));

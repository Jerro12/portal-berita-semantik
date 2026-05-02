<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\SemanticService;
use App\Models\News;

$service = app(SemanticService::class);
echo "Resetting Triplestore data...\n";
$service->getStore()->reset();
echo "Initializing ARC2 Triplestore tables...\n";
$service->getStore()->setUp();

echo "Re-indexing all existing news...\n";
$newsCount = News::count();
foreach (News::all() as $news) {
    echo "Indexing: " . $news->title . "\n";
    $service->indexNews($news);
}

echo "Done! Total news indexed: $newsCount\n";

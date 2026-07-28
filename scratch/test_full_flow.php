<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\News;
use App\Services\SemanticService;

$service = app(SemanticService::class);

echo "1. Creating dummy news...\n";
$news = News::create([
    'title' => 'Test Auto Delete Title',
    'content' => 'Test content for auto delete',
    'category' => 'Teknologi',
    'source' => 'Tester',
    'published_at' => now(),
]);

$id = $news->id;
$uri = url('/ns/news/' . $id);
echo "Created news ID: $id with URI: $uri\n";

$check1 = $service->query("SELECT ?p ?o WHERE { <$uri> ?p ?o }");
echo "Triples in ARC2 after creation: " . count($check1['result']['rows'] ?? []) . "\n";

echo "2. Deleting news via \$news->delete()...\n";
$news->delete();

$check2 = $service->query("SELECT ?p ?o WHERE { <$uri> ?p ?o }");
echo "Triples in ARC2 after deletion: " . count($check2['result']['rows'] ?? []) . "\n";

if (count($check2['result']['rows'] ?? []) === 0) {
    echo "SUCCESS: Triples automatically deleted from ARC2!\n";
} else {
    echo "FAILED: Triples still exist in ARC2!\n";
}

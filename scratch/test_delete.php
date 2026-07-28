<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = app(\App\Services\SemanticService::class);
$store = $service->getStore();

$uri = "http://127.0.0.1:8000/ns/news/13";

echo "--- Test 1: DELETE { <$uri> ?p ?o } WHERE { <$uri> ?p ?o } ---\n";
$res1 = $service->query("DELETE { <$uri> ?p ?o } WHERE { <$uri> ?p ?o }");
echo "Result 1: " . json_encode($res1) . "\n";
$check1 = $service->query("SELECT ?p ?o WHERE { <$uri> ?p ?o }");
echo "Triples left: " . count($check1['result']['rows'] ?? []) . "\n\n";

if (count($check1['result']['rows'] ?? []) > 0) {
    echo "--- Test 2: DELETE FROM <" . url('/graph/news') . "> { <$uri> ?p ?o } ---\n";
    $res2 = $service->query("DELETE FROM <" . url('/graph/news') . "> { <$uri> ?p ?o }");
    echo "Result 2: " . json_encode($res2) . "\n";
    $check2 = $service->query("SELECT ?p ?o WHERE { <$uri> ?p ?o }");
    echo "Triples left: " . count($check2['result']['rows'] ?? []) . "\n\n";
}

if (count($check2['result']['rows'] ?? []) > 0) {
    echo "--- Test 3: \$store->delete(null, \$uri) or direct delete ---\n";
    // Check available methods on ARC2 Store
    $methods = get_class_methods($store);
    echo "ARC2 Store methods: " . implode(', ', array_filter($methods, fn($m) => str_contains(strtolower($m), 'delete'))) . "\n";
}

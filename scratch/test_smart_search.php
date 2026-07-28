<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$smartSearch = app(\App\Services\SmartSearchService::class);

echo "--- Test 1: Query for 'teknologi' --- \n";
$res1 = $smartSearch->search("info terbaru seputar teknologi");
echo "Source: " . $res1['source'] . "\n";
echo "Detected Category: " . ($res1['detected_cat'] ?? 'None') . "\n";
echo "Total results: " . count($res1['results']) . "\n";
foreach ($res1['results'] as $idx => $r) {
    echo "#" . ($idx + 1) . ": " . $r['headline'] . " (" . $r['date'] . ")\n";
}

echo "\n--- Test 2: Query for 'berita hari ini' --- \n";
$res2 = $smartSearch->search("berita hari ini");
echo "Source: " . $res2['source'] . "\n";
echo "Detected Period: " . ($res2['detected_period'] ?? 'None') . "\n";
echo "SPO Triplets: " . json_encode($res2['spo_triplets']) . "\n";
echo "Total results: " . count($res2['results']) . "\n";

<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$smartSearch = app(\App\Services\SmartSearchService::class);

echo "--- Test A: 'carikan artikel revolusi web semantik' --- \n";
$resA = $smartSearch->search("carikan artikel revolusi web semantik");
echo "Data Source: " . $resA['source'] . "\n";
echo "Tokens: " . implode(', ', $resA['tokens']) . "\n";
echo "Total results: " . count($resA['results']) . "\n";
foreach ($resA['results'] as $idx => $r) {
    echo "#" . ($idx + 1) . ": " . $r['headline'] . "\n";
}

echo "\n--- Test B: 'kabar tentang ekonomi' --- \n";
$resB = $smartSearch->search("kabar tentang ekonomi");
echo "Data Source: " . $resB['source'] . "\n";
echo "Detected Category: " . ($resB['detected_cat'] ?? 'None') . "\n";
echo "Total results: " . count($resB['results']) . "\n";
foreach ($resB['results'] as $idx => $r) {
    echo "#" . ($idx + 1) . ": " . $r['headline'] . "\n";
}

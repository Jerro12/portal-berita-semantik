<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$semantic = app(\App\Services\SemanticService::class);

echo "--- Testing STRSTARTS in SPARQL --- \n";
$sparql1 = "
    PREFIX schema: <https://schema.org/>
    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    SELECT ?id ?headline ?date WHERE {
        ?id rdf:type schema:NewsArticle ;
            schema:headline ?headline ;
            schema:datePublished ?date .
        FILTER(STRSTARTS(STR(?date), '2026'))
    }
    LIMIT 5
";
$res1 = $semantic->query($sparql1);
echo "STRSTARTS Result count: " . count($res1['result']['rows'] ?? []) . "\n";
if (!empty($res1['result']['rows'])) {
    echo "First headline: " . $res1['result']['rows'][0]['headline'] . "\n";
}

echo "--- Testing CONTAINS in SPARQL --- \n";
$sparql2 = "
    PREFIX schema: <https://schema.org/>
    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    SELECT ?id ?headline ?date WHERE {
        ?id rdf:type schema:NewsArticle ;
            schema:headline ?headline ;
            schema:datePublished ?date .
        FILTER(CONTAINS(STR(?date), '2026'))
    }
    LIMIT 5
";
$res2 = $semantic->query($sparql2);
echo "CONTAINS Result count: " . count($res2['result']['rows'] ?? []) . "\n";

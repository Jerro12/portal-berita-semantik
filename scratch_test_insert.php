<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\SemanticService;

$service = app(SemanticService::class);
echo "Testing manual INSERT DATA...\n";

$q = "
    INSERT DATA {
        <http://example.org/test> <http://example.org/prop> 'Hello World' .
    }
";

$res = $service->query($q);
echo "Query Result:\n";
print_r($res);

echo "\nChecking if data exists...\n";
$check = $service->query("SELECT * WHERE { <http://example.org/test> ?p ?o }");
print_r($check);

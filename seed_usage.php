<?php

use App\Models\AiUsageLog;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Seed a usage log
AiUsageLog::create([
    'user_id' => 1,
    'request_type' => 'test_seed',
    'input_tokens' => 1000,
    'output_tokens' => 500,
    'cost' => 1.25, // Specifically setting this to verify the sum logic
]);

echo "Seeded usage log with cost $1.25\n";

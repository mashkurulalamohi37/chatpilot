<?php
/**
 * Laravel Cache Clearer for Shared Hosting
 * Place this file in your root folder (htdocs) and visit it in browser.
 */

// Load Laravel Setup
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;

echo "<h1>🧹 Cleaning Application Cache...</h1>";

echo "<h3>1. Clearing Route Cache...</h3>";
try {
    Artisan::call('route:clear');
    echo "✅ " . Artisan::output() . "<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h3>2. Clearing Config Cache...</h3>";
try {
    Artisan::call('config:clear');
    echo "✅ " . Artisan::output() . "<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h3>3. Clearing View Cache...</h3>";
try {
    Artisan::call('view:clear');
    echo "✅ " . Artisan::output() . "<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>🎉 All Done! Go back and try your link again.</h2>";
echo "<a href='/'>Return to Home</a>";
?>

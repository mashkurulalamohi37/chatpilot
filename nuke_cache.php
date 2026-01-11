<?php
/**
 * Hard Cache Cleaner
 * Deletes the cache files directly from the filesystem.
 */

echo "<h1>🧨 Nuke Cache Started</h1>";

$files = [
    __DIR__.'/bootstrap/cache/config.php',
    __DIR__.'/bootstrap/cache/routes.php',
    __DIR__.'/bootstrap/cache/packages.php',
    __DIR__.'/bootstrap/cache/services.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "✅ Deleted: " . basename($file) . "<br>";
        } else {
            echo "❌ Failed to delete: " . basename($file) . " (Permission Denied)<br>";
        }
    } else {
        echo "ℹ️ Not found (Good): " . basename($file) . "<br>";
    }
}

echo "<h3>Cleaning Views...</h3>";
$viewFiles = glob(__DIR__.'/storage/framework/views/*.php');
$count = 0;
foreach ($viewFiles as $file) {
    if(is_file($file)) {
        unlink($file);
        $count++;
    }
}
echo "✅ Deleted $count compiled view files.<br>";

echo "<hr>";
echo "<h2>✅ Cache is NUKED.</h2>";
echo "<h3>👇 IMPORTANT: CLICK THIS LINK TO TEST 👇</h3>";
echo "<h2><a href='/live-chat'>CLICK HERE: /live-chat</a></h2>";
?>

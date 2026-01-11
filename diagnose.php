<?php
echo "<pre>";
echo "<h1>🕵️ Server Diagnosis</h1>";

// 1. Check Route File Content
echo "<h3>1. Checking routes/web.php content:</h3>";
$content = file_get_contents(__DIR__ . '/routes/web.php');
if (strpos($content, '/live-chat') !== false) {
    echo "✅ routes/web.php contains '/live-chat' (Good)\n";
} else {
    echo "❌ routes/web.php MISSING '/live-chat' (Bad - File didn't update)\n";
}
// Show relevant lines
preg_match_all('/Route::.*chat.*/i', $content, $matches);
print_r($matches[0]);


// 2. Check for Cache Files
echo "\n<h3>2. Checking Cache Files (Should be gone):</h3>";
$files = [
    'bootstrap/cache/routes.php',
    'bootstrap/cache/config.php'
];
foreach ($files as $f) {
    if (file_exists(__DIR__ . '/' . $f)) {
        echo "❌ Cache file exists: $f (BAD - Nuke failed)\n";
    } else {
        echo "✅ Cache file missing: $f (Good)\n";
    }
}

// 3. Check for Folder Conflicts
echo "\n<h3>3. Checking for conflicting folders:</h3>";
if (is_dir(__DIR__ . '/chat')) {
    echo "❌ 'chat' folder exists! (This causes 403 Forbidden)\n";
} else {
    echo "✅ 'chat' folder does not exist.\n";
}
if (is_dir(__DIR__ . '/public')) {
    echo "⚠️ 'public' folder exists (Might cause confusion, but okay)\n";
}

echo "</pre>";
?>

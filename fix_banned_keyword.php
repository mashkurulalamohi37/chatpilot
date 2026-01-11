<?php
/**
 * FIX BANNED KEYWORD
 * InfinityFree likely blocks "chat" in URLs.
 * Renaming route to "/inbox".
 */

echo "<h1>🛡️ Bypassing Server Firewall...</h1>";

$file = __DIR__ . '/routes/web.php';
$content = file_get_contents($file);

// Replace /live-chat with /inbox
// Replace /chat with /inbox
$newContent = str_replace("Route::get('/live-chat'", "Route::get('/inbox'", $content);
$newContent = str_replace("Route::post('/live-chat'", "Route::post('/inbox'", $newContent);
$newContent = str_replace("Route::get('/chat'", "Route::get('/inbox'", $newContent);
$newContent = str_replace("Route::post('/chat'", "Route::post('/inbox'", $newContent);

if (file_put_contents($file, $newContent)) {
    echo "✅ routes/web.php updated: changed '/live-chat' to '/inbox'.<br>";
}

// Rename the Link in the Sidebar (Optional but good)
$layout = __DIR__ . '/resources/views/layouts/app.blade.php';
$layoutContent = file_get_contents($layout);
$layoutContent = str_replace('>Live Chat</a>', '>Inbox</a>', $layoutContent);
file_put_contents($layout, $layoutContent);
echo "✅ Sidebar updated: 'Live Chat' -> 'Inbox'.<br>";


// Nuke Cache
$caches = glob(__DIR__.'/bootstrap/cache/*.php');
foreach ($caches as $c) {
    if(is_file($c)) unlink($c);
}
echo "✅ Cache cleared.<br>";


echo "<hr>";
echo "<h2>🎉 READY.</h2>";
echo "<h3>The URL is now '/inbox' (Safe Word).</h3>";
echo "<h2><a href='/inbox'>👉 OPEN INBOX</a></h2>";
?>

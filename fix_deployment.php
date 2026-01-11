<?php
/**
 * Auto-Fixer for InfinityFree Deployment
 * Moves files from /public to / (root) and updates index.php paths.
 */

echo "<h2>Starting Auto-Fix...</h2>";

// 1. Move everything from public folder to root
$source = __DIR__ . '/public';
$dest = __DIR__;

if (is_dir($source)) {
    $files = scandir($source);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            if (rename($source . '/' . $file, $dest . '/' . $file)) {
                echo "✅ Moved: <b>$file</b><br>";
            } else {
                echo "❌ Failed to move: $file (might already exist)<br>";
            }
        }
    }
    // Try to remove the now empty public dir
    @rmdir($source);
} else {
    echo "⚠️ 'public' folder not found (maybe you already moved them?). checking index.php...<br>";
}

// 2. Fix index.php code
$indexFile = __DIR__ . '/index.php';

if (file_exists($indexFile)) {
    $code = file_get_contents($indexFile);
    
    // Check if duplicate changes happened, if not, apply fix
    if (strpos($code, '/../vendor') !== false) {
        // Remove the /.. to point to current directory
        $code = str_replace(__DIR__.'/../storage', __DIR__.'/storage', $code); // Hard replace attempt
        $code = str_replace('/../storage', '/storage', $code);
        $code = str_replace('/../vendor', '/vendor', $code);
        $code = str_replace('/../bootstrap', '/bootstrap', $code);
        
        file_put_contents($indexFile, $code);
        echo "✅ Updated <b>index.php</b> paths successfully.<br>";
    } else {
        echo "ℹ️ <b>index.php</b> already seems fixed.<br>";
    }
} else {
    echo "❌ <b>index.php</b> not found in root!<br>";
}

echo "<hr>";
echo "<h3>🎉 Fix Complete!</h3>";
echo "<a href='/' style='font-size:20px; background:blue; color:white; padding:10px; text-decoration:none; border-radius:5px;'>Click Here to View Your Site</a>";
?>

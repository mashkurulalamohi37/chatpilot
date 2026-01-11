<?php
/**
 * Auto-Fix .htaccess (Version 3)
 * The "Super Safe" Version.
 * Uses standard "WordPress-style" rewrites which work on 99% of servers.
 */

$file = __DIR__ . '/.htaccess';

$content = <<<'EOD'
DirectoryIndex index.php

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    # If it's a real file or folder, serve it directly
    RewriteCond %{REQUEST_FILENAME} -f [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^ - [L]

    # Otherwise, send everything to index.php
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
EOD;

if (file_put_contents($file, $content)) {
    echo "<h1>✅ .htaccess (v3) Updated!</h1>";
    echo "<p>Using the simplified, most compatible rewrite rules.</p>";
    echo "<h3>👇 TEST LINKS 👇</h3>";
    echo "<ul>";
    echo "<li><a href='/live-chat'>Test: /live-chat</a></li>";
    echo "<li><a href='/contacts'>Test: /contacts</a></li>";
    echo "</ul>";
} else {
    echo "<h1>❌ Error</h1>";
    echo "<p>Could not write to .htaccess. Check permissions.</p>";
}
?>

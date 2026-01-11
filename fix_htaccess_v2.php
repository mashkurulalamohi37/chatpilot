<?php
/**
 * Auto-Fix .htaccess (Version 2)
 * Adds RewriteBase / and removes potentially restricted Options.
 */

$file = __DIR__ . '/.htaccess';

$content = <<<'EOD'
<IfModule mod_rewrite.c>
    # Removed "Options" in case your host blocks it (causes 500 error)
    
    RewriteEngine On
    RewriteBase /

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOD;

if (file_put_contents($file, $content)) {
    echo "<h1>✅ .htaccess (v2) Updated!</h1>";
    echo "<p>I added 'RewriteBase /' and removed strict options.</p>";
    echo "<h3>👇 TRY AGAIN NOW 👇</h3>";
    echo "<h2><a href='/live-chat'>OPEN LIVE CHAT</a></h2>";
} else {
    echo "<h1>❌ Error</h1>";
    echo "<p>Could not write to .htaccess. Check permissions.</p>";
}
?>

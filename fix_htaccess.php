<?php
/**
 * Auto-Fix .htaccess
 * Creates the standard Laravel .htaccess file.
 */

$file = __DIR__ . '/.htaccess';

$content = <<<'EOD'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

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
    echo "<h1>✅ .htaccess Created Successfully!</h1>";
    echo "<p>Your links should work now.</p>";
    echo "<h3><a href='/live-chat'>Test Live Chat Link</a></h3>";
} else {
    echo "<h1>❌ Error</h1>";
    echo "<p>Could not write to .htaccess. Check permissions.</p>";
}
?>

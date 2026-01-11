<?php
/**
 * EMERGENCY FIX
 * 1. Forcefully updates routes/web.php to use /live-chat
 * 2. Nukes all caches
 */

echo "<h1>🚑 Emergency Fix Running...</h1>";

// 1. Overwrite routes/web.php with the CORRECT content
$routeFile = __DIR__ . '/routes/web.php';
$newContent = <<<'EOD'
<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Campaign Routes
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');

    // Contact Routes
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // WhatsApp Routes
    Route::get('/whatsapp/connect', [WhatsAppController::class, 'connect'])->name('whatsapp.connect');
    Route::post('/whatsapp/connect', [WhatsAppController::class, 'store'])->name('whatsapp.store');

    // Chat Routes (RENAMED TO PREVENT 403 ERROR)
    Route::get('/live-chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/live-chat', [ChatController::class, 'store'])->name('chat.store');

    // AI Routes
    Route::get('/ai/config', [AiController::class, 'config'])->name('ai.config');
    Route::post('/ai/config', [AiController::class, 'update'])->name('ai.update');
    
    // Payment Routes
    Route::get('/payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
});

Route::post('/stripe/webhook', [PaymentController::class, 'webhook'])->name('stripe.webhook');
EOD;

if (file_put_contents($routeFile, $newContent)) {
    echo "✅ <b>routes/web.php</b> has been FINALLY updated to use /live-chat.<br>";
} else {
    echo "❌ Failed to update routes/web.php (Permission Denied).<br>";
}

// 2. Nuke Cache (Again, just to be sure)
$cacheFiles = [
    __DIR__.'/bootstrap/cache/config.php',
    __DIR__.'/bootstrap/cache/routes.php', 
    __DIR__.'/bootstrap/cache/packages.php',
    __DIR__.'/bootstrap/cache/services.php'
];

foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "✅ Deleted cache: " . basename($file) . "<br>";
    }
}

echo "<hr>";
echo "<h2>✅ Fix Applied.</h2>";
echo "<h3><a href='/live-chat' style='font-size: 24px; color: red;'>👉 CLICK HERE TO OPEN CHAT 👈</a></h3>";
?>

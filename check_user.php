<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$user = \App\Models\User::find(1);
if ($user) {
    echo "User 1 exists: " . $user->email;
} else {
    echo "User 1 DOES NOT EXIST";
    try {
         \App\Models\User::create([
             'id' => 1, 
             'name' => 'Admin', 
             'email' => 'admin@example.com', 
             'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password
         ]);
         echo " ... Created User 1 via create()";
    } catch (\Exception $e) {
        echo " ... Error creating: " . $e->getMessage();
    }
}

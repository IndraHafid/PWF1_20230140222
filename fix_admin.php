<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FIXING ADMIN USER ===\n";

// Find user by email and update to admin
$user = App\Models\User::where('email', 'admin@gmail.com')->first();

if($user) {
    $user->role = 'admin';
    $user->save();
    echo "User admin@gmail.com updated to: {$user->role}\n";
} else {
    echo "User admin@gmail.com not found!\n";
}

// Check all users again
echo "\n=== ALL USERS ===\n";
$users = App\Models\User::all();
foreach($users as $user) {
    echo "ID: {$user->id} | Email: {$user->email} | Role: {$user->role}\n";
}

<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FIXING ALL ADMIN USERS ===\n";

// Update admin1@gmail.com to admin
$user1 = App\Models\User::where('email', 'admin1@gmail.com')->first();
if($user1) {
    $user1->role = 'admin';
    $user1->save();
    echo "User admin1@gmail.com updated to: {$user1->role}\n";
}

// Update admin@gmail.com to admin (double check)
$user2 = App\Models\User::where('email', 'admin@gmail.com')->first();
if($user2) {
    $user2->role = 'admin';
    $user2->save();
    echo "User admin@gmail.com updated to: {$user2->role}\n";
}

// Check all users
echo "\n=== FINAL USER LIST ===\n";
$users = App\Models\User::all();
foreach($users as $user) {
    $status = $user->role === 'admin' ? 'ADMIN' : 'USER';
    echo "ID: {$user->id} | Email: {$user->email} | Role: {$user->role} | Status: {$status}\n";
}

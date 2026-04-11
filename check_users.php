<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== USERS LIST ===\n";
$users = App\Models\User::all();

foreach($users as $user) {
    echo "ID: {$user->id} | Email: {$user->email} | Role: {$user->role}\n";
}

echo "\n=== UPDATING FIRST USER TO ADMIN ===\n";
if($users->count() > 0) {
    $firstUser = $users->first();
    $firstUser->role = 'admin';
    $firstUser->save();
    echo "User {$firstUser->email} updated to admin!\n";
}

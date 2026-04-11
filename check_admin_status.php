<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECK ADMIN STATUS ===\n";

// Check all admin users
$adminUsers = App\Models\User::where('role', 'admin')->get();

echo "Found {$adminUsers->count()} admin users:\n";
foreach($adminUsers as $admin) {
    echo "- Email: {$admin->email} | Name: {$admin->name} | Role: {$admin->role}\n";
}

echo "\n=== LOGIN INFO ===\n";
echo "Use one of these admin accounts to see Add Product button:\n";
echo "Email: admin@gmail.com\n";
echo "Email: admin1@gmail.com (if updated)\n";
echo "Email: admin@example.com\n";

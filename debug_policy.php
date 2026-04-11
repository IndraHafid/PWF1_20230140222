<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG POLICY ===\n";

// Get users
$admin = App\Models\User::where('role', 'admin')->first();
$regularUser = App\Models\User::where('role', 'user')->first();

echo "Admin: {$admin->name} (ID: {$admin->id})\n";
echo "Regular User: {$regularUser->name} (ID: {$regularUser->id})\n";

// Get products
$products = App\Models\Product::with('user')->get();

foreach($products as $product) {
    echo "\nProduct: {$product->name} (Owner: {$product->user->name}, ID: {$product->user_id})\n";
    
    // Test admin permissions
    $adminCanUpdate = (new App\Policies\ProductPolicy)->update($admin, $product);
    $adminCanDelete = (new App\Policies\ProductPolicy)->delete($admin, $product);
    echo "Admin can update: " . ($adminCanUpdate ? 'YES' : 'NO') . "\n";
    echo "Admin can delete: " . ($adminCanDelete ? 'YES' : 'NO') . "\n";
    
    // Test regular user permissions
    $userCanUpdate = (new App\Policies\ProductPolicy)->update($regularUser, $product);
    $userCanDelete = (new App\Policies\ProductPolicy)->delete($regularUser, $product);
    echo "User {$regularUser->name} can update: " . ($userCanUpdate ? 'YES' : 'NO') . "\n";
    echo "User {$regularUser->name} can delete: " . ($userCanDelete ? 'YES' : 'NO') . "\n";
}

<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG USER POLICY ===\n";

// Get a regular user and their products
$regularUser = App\Models\User::where('role', 'user')->first();
echo "Regular User: {$regularUser->name} (ID: {$regularUser->id}, Role: {$regularUser->role})\n";

// Get products owned by this user
$userProducts = App\Models\Product::where('user_id', $regularUser->id)->get();

echo "\nProducts owned by {$regularUser->name}:\n";
foreach($userProducts as $product) {
    echo "- {$product->name} (ID: {$product->id}, Owner ID: {$product->user_id})\n";
    
    // Test policy
    $canUpdate = (new App\Policies\ProductPolicy)->update($regularUser, $product);
    $canDelete = (new App\Policies\ProductPolicy)->delete($regularUser, $product);
    
    echo "  Can update: " . ($canUpdate ? 'YES' : 'NO') . "\n";
    echo "  Can delete: " . ($canDelete ? 'YES' : 'NO') . "\n";
    
    // Debug the logic
    echo "  Debug: user->id ({$regularUser->id}) == product->user_id ({$product->user_id}) = " . ($regularUser->id == $product->user_id ? 'TRUE' : 'FALSE') . "\n";
    echo "  Debug: user->role ({$regularUser->role}) == admin = " . ($regularUser->role === 'admin' ? 'TRUE' : 'FALSE') . "\n";
    echo "  Debug: Final result = " . (($regularUser->role === 'admin' || $regularUser->id == $product->user_id) ? 'TRUE' : 'FALSE') . "\n\n";
}

// Also test with products NOT owned by this user
$otherProducts = App\Models\Product::where('user_id', '!=', $regularUser->id)->get();

echo "\nProducts NOT owned by {$regularUser->name}:\n";
foreach($otherProducts->take(2) as $product) {
    echo "- {$product->name} (ID: {$product->id}, Owner: {$product->user->name})\n";
    
    $canUpdate = (new App\Policies\ProductPolicy)->update($regularUser, $product);
    $canDelete = (new App\Policies\ProductPolicy)->delete($regularUser, $product);
    
    echo "  Can update: " . ($canUpdate ? 'YES' : 'NO') . "\n";
    echo "  Can delete: " . ($canDelete ? 'YES' : 'NO') . "\n\n";
}

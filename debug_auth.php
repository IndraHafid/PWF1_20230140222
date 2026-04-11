<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG AUTH & POLICY ===\n";

// Check if AuthServiceProvider is registered
echo "1. Checking AuthServiceProvider registration...\n";
$providers = $app->getProviders(\App\Providers\AuthServiceProvider::class);
if (count($providers) > 0) {
    echo "   AuthServiceProvider is registered: YES\n";
} else {
    echo "   AuthServiceProvider is registered: NO\n";
    echo "   This is the problem! Policy won't work.\n";
}

// Check policy registration
echo "\n2. Checking policy registration...\n";
$authServiceProvider = $app->make(\App\Providers\AuthServiceProvider::class);
$policies = $authServiceProvider->getPolicies();
echo "   Registered policies:\n";
foreach($policies as $model => $policy) {
    echo "   - $model => $policy\n";
}

// Test Gate functionality
echo "\n3. Testing Gate functionality...\n";
$gate = $app->make('Illuminate\Auth\Access\Gate');
$gates = $gate->abilities();
echo "   Registered gates:\n";
foreach($gates as $gateName => $callback) {
    echo "   - $gateName\n";
}

// Test with actual users and products
echo "\n4. Testing policy with actual data...\n";

// Get regular user
$regularUser = \App\Models\User::where('role', 'user')->first();
echo "   Regular User: {$regularUser->name} (ID: {$regularUser->id})\n";

// Get user's product
$userProduct = \App\Models\Product::where('user_id', $regularUser->id)->first();
if ($userProduct) {
    echo "   User Product: {$userProduct->name} (Owner ID: {$userProduct->user_id})\n";
    
    // Test using Gate
    $canUpdate = $gate->allows('update', $userProduct);
    $canDelete = $gate->allows('delete', $userProduct);
    
    echo "   Gate allows update: " . ($canUpdate ? 'YES' : 'NO') . "\n";
    echo "   Gate allows delete: " . ($canDelete ? 'YES' : 'NO') . "\n";
    
    // Test using Policy directly
    $policy = new \App\Policies\ProductPolicy();
    $policyUpdate = $policy->update($regularUser, $userProduct);
    $policyDelete = $policy->delete($regularUser, $userProduct);
    
    echo "   Policy allows update: " . ($policyUpdate ? 'YES' : 'NO') . "\n";
    echo "   Policy allows delete: " . ($policyDelete ? 'YES' : 'NO') . "\n";
} else {
    echo "   No products found for this user\n";
}

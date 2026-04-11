<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SIMPLE POLICY TEST ===\n";

// Get user and product
$user = \App\Models\User::where('role', 'user')->first();
$product = \App\Models\Product::where('user_id', $user->id)->first();

echo "User: {$user->name} (ID: {$user->id})\n";
echo "Product: {$product->name} (Owner ID: {$product->user_id})\n";

// Test policy directly
$policy = new \App\Policies\ProductPolicy();
echo "Direct policy test:\n";
echo "Update: " . ($policy->update($user, $product) ? 'YES' : 'NO') . "\n";
echo "Delete: " . ($policy->delete($user, $product) ? 'YES' : 'NO') . "\n";

// Test with Laravel's authorization system
echo "\nLaravel authorization test:\n";
try {
    $canUpdate = \Illuminate\Support\Facades\Gate::allows('update', $product);
    $canDelete = \Illuminate\Support\Facades\Gate::allows('delete', $product);
    echo "Gate allows update: " . ($canUpdate ? 'YES' : 'NO') . "\n";
    echo "Gate allows delete: " . ($canDelete ? 'YES' : 'NO') . "\n";
} catch (Exception $e) {
    echo "Gate test failed: " . $e->getMessage() . "\n";
}

// Check if policy is registered
echo "\nPolicy registration check:\n";
$policies = app('Illuminate\Auth\Access\Gate')->getPolicies();
echo "Policies registered:\n";
foreach($policies as $model => $policyClass) {
    echo "- $model => $policyClass\n";
}

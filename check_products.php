<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING PRODUCTS ===\n";

// Check if products table exists and has data
try {
    $products = App\Models\Product::with('user')->get();
    
    if($products->count() > 0) {
        echo "Found {$products->count()} products:\n";
        foreach($products as $product) {
            echo "- ID: {$product->id} | Name: {$product->name} | Qty: {$product->qty} | Price: {$product->price} | Owner: " . ($product->user ? $product->user->name : 'N/A') . "\n";
        }
    } else {
        echo "No products found. Creating sample data...\n";
        
        // Create sample products
        $admin = App\Models\User::where('role', 'admin')->first();
        $user = App\Models\User::where('role', 'user')->first();
        
        if($admin) {
            App\Models\Product::create([
                'name' => 'Laptop ASUS ROG',
                'qty' => 5,
                'price' => 15000000,
                'user_id' => $admin->id
            ]);
            echo "Created product for admin: {$admin->name}\n";
        }
        
        if($user) {
            App\Models\Product::create([
                'name' => 'Mouse Logitech',
                'qty' => 15,
                'price' => 250000,
                'user_id' => $user->id
            ]);
            echo "Created product for user: {$user->name}\n";
        }
    }
    
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

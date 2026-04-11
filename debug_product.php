<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG PRODUCT PAGE ===\n";

try {
    // Test ProductController index method
    $products = App\Models\Product::with('user')->get();
    
    echo "Products count: " . $products->count() . "\n";
    
    // Test view rendering
    $viewData = ['products' => $products];
    
    echo "View data prepared successfully\n";
    echo "First product: " . ($products->first() ? $products->first()->name : 'None') . "\n";
    
    // Check if user relationship works
    foreach($products as $product) {
        echo "Product: {$product->name} | Owner: " . ($product->user ? $product->user->name : 'No owner') . "\n";
    }
    
    echo "\n=== CHECKING VIEW FILE ===\n";
    $viewPath = __DIR__ . '/resources/views/product/index.blade.php';
    if(file_exists($viewPath)) {
        echo "View file exists: {$viewPath}\n";
    } else {
        echo "View file NOT found: {$viewPath}\n";
    }
    
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

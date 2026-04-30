<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/about', [AboutController::class, 'index'])
    ->middleware(['auth'])
    ->name('about');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/{id}/json', [ProductController::class, 'showJson'])->name('product.show.json');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    
    // Category routes (admin only)
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index')->can('manage-category');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create')->can('manage-category');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store')->can('manage-category');
    Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit')->can('manage-category');
    Route::put('/category/update/{category}', [CategoryController::class, 'update'])->name('category.update')->can('manage-category');
    Route::delete('/category/delete/{category}', [CategoryController::class, 'delete'])->name('category.delete')->can('manage-category');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
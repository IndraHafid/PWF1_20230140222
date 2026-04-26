<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function store(\App\Http\Requests\StoreProductRequest $request)
    {
Log::info('Product store validated data:', $request->validated());
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();
        $validated['qty'] = $validated['quantity'];
        unset($validated['quantity']); // Remove quantity field

        try {
            Product::create($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');
        } catch (QueryException $e) {
            Log::error('Product store database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while creating product.');
        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
    }

    public function create()
    {
        return view('product.create');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function showJson($id)
    {
        $product = Product::with('user')->findOrFail($id);
        
        // Check permissions
        $policy = new \App\Policies\ProductPolicy();
        
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $product->qty,
            'price' => $product->price,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'user' => [
                'name' => $product->user->name ?? null,
            ],
            'can_update' => $policy->update(auth()->user(), $product),
            'can_delete' => $policy->delete(auth()->user(), $product),
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // Manual policy check
        $policy = new \App\Policies\ProductPolicy();
        if (!$policy->update(auth()->user(), $product)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        // Map quantity to qty for database
        if (isset($validated['quantity'])) {
            $validated['qty'] = $validated['quantity'];
            unset($validated['quantity']);
        }

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function edit(Product $product)
    {
        // Manual policy check
        $policy = new \App\Policies\ProductPolicy();
        if (!$policy->update(auth()->user(), $product)) {
            abort(403, 'Unauthorized action.');
        }
        
        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        
        // Manual policy check
        $policy = new \App\Policies\ProductPolicy();
        if (!$policy->delete(auth()->user(), $product)) {
            abort(403, 'Unauthorized action.');
        }
        
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}
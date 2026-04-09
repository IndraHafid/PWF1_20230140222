<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('product.index') }}"
                               class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                                ←
                            </a>

                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                                    Product Detail
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Viewing product
                                    <span class="font-medium text-gray-700 dark:text-gray-300">
                                        {{ $product->name }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('product.edit', $product) }}"
                               class="px-3 py-1.5 text-sm rounded-lg border border-yellow-400 text-yellow-600 hover:bg-yellow-50">
                                Edit
                            </a>

                            <form action="{{ route('product.delete', $product->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1.5 text-sm rounded-lg border border-red-400 text-red-600 hover:bg-red-50">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Detail Card -->
                    <div class="rounded-lg border border-gray-200 divide-y">

                        <!-- Name -->
                        <div class="flex items-center px-5 py-4">
                            <div class="w-1/3 text-sm text-gray-500">Product Name</div>
                            <div class="font-semibold">{{ $product->name }}</div>
                        </div>

                        <!-- Quantity -->
                        <div class="flex items-center px-5 py-4">
                            <div class="w-1/3 text-sm text-gray-500">Quantity</div>
                            <div>
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    {{ $product->quantity > 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $product->quantity }}
                                    ({{ $product->quantity > 10 ? 'In Stock' : 'Low Stock' }})
                                </span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center px-5 py-4">
                            <div class="w-1/3 text-sm text-gray-500">Price</div>
                            <div class="font-mono">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Owner -->
                        <div class="flex items-center px-5 py-4">
                            <div class="w-1/3 text-sm text-gray-500">Owner</div>
                            <div>
                                {{ $product->user->name ?? '-' }}
                            </div>
                        </div>

                        <!-- Created At -->
                        <div class="flex items-center px-5 py-4">
                            <div class="w-1/3 text-sm text-gray-500">Created At</div>
                            <div>
                                {{ $product->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <!-- Updated At -->
                        <div class="flex items-center px-5 py-4">
                            <div class="w-1/3 text-sm text-gray-500">Updated At</div>
                            <div>
                                {{ $product->updated_at->format('d M Y, H:i') }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
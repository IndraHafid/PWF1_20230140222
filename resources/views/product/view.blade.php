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
                            @php
                            $policy = new \App\Policies\ProductPolicy();
                            $canUpdate = $policy->update(auth()->user(), $product);
                            @endphp
                            @if($canUpdate)
                            <x-edit-button :url="route('product.edit', $product)" title="Edit Product" />
                            @endif

                            @php
                            $canDelete = $policy->delete(auth()->user(), $product);
                            @endphp
                            @if($canDelete)
                            <x-delete-button :url="route('product.delete', $product->id)" 
                                            title="Delete Product" 
                                            confirm-message="Are you sure you want to delete this product?" />
                            @endif
                        </div>
                    </div>

                    <!-- Detail Card -->
                    <div class="rounded-lg border border-gray-200 divide-y">

                        <!-- Name -->
                        <div class="px-4 py-2 border rounded-lg text-sm text-grey-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-150">
                            <div class="w-1/3 text-sm text-gray-500 dark:text-gray-400">Product Name</div>
                            <div class="font-semibold text-gray-800 dark:text-white">{{ $product->name }}</div>
                        </div>

                        <!-- Quantity -->
                        <div class="px-4 py-2 border rounded-lg text-sm text-grey-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-150">
                            <div class="w-1/3 text-sm text-gray-500 dark:text-gray-400">Quantity</div>
                            <div>
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    {{ $product->qty > 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-700' }}">
                                    {{ $product->qty }}
                                    ({{ $product->qty > 10 ? 'In Stock' : 'Low Stock' }})
                                </span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="px-4 py-2 border rounded-lg text-sm text-grey-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-150">
                            <div class="w-1/3 text-sm text-gray-500 dark:text-gray-400">Price</div>
                            <div class="font-mono text-gray-800 dark:text-white">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="px-4 py-2 border rounded-lg text-sm text-grey-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-150">
                            <div class="w-1/3 text-sm text-gray-500 dark:text-gray-400">Category</div>
                            <div class="text-gray-800 dark:text-white">
                                @if($product->category)
                                    {{ $product->category->name }}
                                @else
                                    No Category (ID: {{ $product->category_id }})
                                @endif
                            </div>
                        </div>

                        <!-- Owner -->
                        <div class="px-4 py-2 border rounded-lg text-sm text-grey-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-150">
                            <div class="w-1/3 text-sm text-gray-500 dark:text-gray-400">Owner</div>
                            <div class="text-gray-800 dark:text-white">
                                {{ $product->user->name ?? '-' }}
                            </div>
                        </div>

                        <!-- Created At -->
                        <div class="px-4 py-2 border rounded-lg text-sm text-grey-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-150">
                            <div class="w-1/3 text-sm text-gray-500 dark:text-gray-400">Created At</div>
                            <div class="text-gray-800 dark:text-white">
                                {{ $product->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <!-- Updated At -->
                        <div class="px-4 py-2 border rounded-lg text-sm text-grey-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-150">
                            <div class="w-1/3 text-sm text-gray-500 dark:text-gray-400">Updated At</div>
                            <div class="text-gray-800 dark:text-white">
                                {{ $product->updated_at->format('d M Y, H:i') }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
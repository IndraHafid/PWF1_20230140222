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
                            <a href="{{ route('product.edit', $product) }}"
                               class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg border border-yellow-400"
                               title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            @endif

                            @php
                            $canDelete = $policy->delete(auth()->user(), $product);
                            @endphp
                            @if($canDelete)
                            <form action="{{ route('product.delete', $product->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg border border-red-400"
                                        title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif
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
<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Header -->
                    <div class="flex items-center gap-3 mb-6">
                        <a href="{{ route('product.show', $product) }}"
                           class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                            ←
                        </a>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                                Edit Product
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Update details for 
                                <span class="font-medium text-gray-700 dark:text-gray-300">
                                    {{ $product->name }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Delete Form -->
                    <form id="delete-product-form"
                          action="{{ route('product.delete', $product->id) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                    </form>

                    <!-- Form Update -->
                    <form action="{{ route('product.update', $product) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name"
                                   value="{{ old('name', $product->name) }}"
                                   placeholder="e.g. Wireless Headphones"
                                   class="w-full px-4 py-2.5 rounded-lg border text-sm
                                   @error('name') border-red-400 @else border-gray-300 @enderror">
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity & Price -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Quantity <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="quantity"
                                       value="{{ old('quantity', $product->quantity) }}"
                                       min="0"
                                       class="w-full px-4 py-2.5 rounded-lg border text-sm
                                       @error('quantity') border-red-400 @else border-gray-300 @enderror">
                                @error('quantity')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Price (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="price"
                                       value="{{ old('price', $product->price) }}"
                                       step="0.01"
                                       class="w-full px-4 py-2.5 rounded-lg border text-sm
                                       @error('price') border-red-400 @else border-gray-300 @enderror">
                                @error('price')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- User -->
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Owner <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id"
                                    class="w-full px-4 py-2.5 rounded-lg border text-sm
                                    @error('user_id') border-red-400 @else border-gray-300 @enderror">
                                <option value="">Select Owner</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $product->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-2">

                            <!-- Delete Button -->
                            <button type="submit"
                                    form="delete-product-form"
                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                    class="px-3 py-2 text-sm text-red-500 hover:text-red-700">
                                Delete Product
                            </button>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('product.show', $product) }}"
                                   class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                                    Cancel
                                </a>

                                <button type="submit"
                                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">
                                    Update Product
                                </button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
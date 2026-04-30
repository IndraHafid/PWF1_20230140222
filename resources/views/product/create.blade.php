<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Header -->
                    <div class="flex items-center gap-3 mb-6">
                        <a href="{{ route('product.index') }}"
                           class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                            ←
                        </a>

                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                                Add Product
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Fill in the details to add a new product
                            </p>
                        </div>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('product.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   placeholder="e.g. Wireless Headphones"
                                   class="w-full px-4 py-2.5 rounded-lg border text-sm bg-gray-50 text-gray-900
                                   @error('name') border-red-400 @else border-gray-300 @enderror">
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" 
                                    class="w-full px-4 py-2.5 rounded-lg border text-sm bg-gray-50 text-gray-900
                                    @error('category_id') border-red-400 @else border-gray-300 @enderror">
                                <option value="" style="color: #9CA3AF;">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity & Price -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Quantity <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="quantity" value="{{ old('quantity') }}"
                                       min="0"
                                       placeholder="10"
                                       class="w-full px-4 py-2.5 rounded-lg border text-sm bg-gray-50 text-gray-900
                                       @error('quantity') border-red-400 @else border-gray-300 @enderror">
                                @error('quantity')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Price (Rp) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="price" value="{{ old('price') }}"
                                       step="0.01"
                                       placeholder="100000"
                                       class="w-full px-4 py-2.5 rounded-lg border text-sm bg-gray-50 text-gray-900
                                       @error('price') border-red-400 @else border-gray-300 @enderror">
                                @error('price')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-3 pt-2">
                            <a href="{{ route('product.index') }}"
                               class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Product
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Form submission handler
    form.addEventListener('submit', function(e) {
        // Disable submit button to prevent double submission
        submitButton.disabled = true;
        submitButton.textContent = 'Saving...';
        
        // Re-enable after 3 seconds in case of errors
        setTimeout(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'Save Product';
        }, 3000);
    });
    
    // Simple input validation - only allow valid characters
    const quantityInput = document.querySelector('input[name="quantity"]');
    if (quantityInput) {
        quantityInput.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
    
    const priceInput = document.querySelector('input[name="price"]');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            // Only allow numbers and decimal point
            this.value = this.value.replace(/[^0-9.]/g, '');
            
            // Prevent multiple decimal points
            const parts = this.value.split('.');
            if (parts.length > 2) {
                this.value = parts[0] + '.' + parts.slice(1).join('');
            }
            
            // Limit to 2 decimal places
            if (parts.length === 2 && parts[1].length > 2) {
                this.value = parts[0] + '.' + parts[1].substring(0, 2);
            }
        });
    }
});
</script>
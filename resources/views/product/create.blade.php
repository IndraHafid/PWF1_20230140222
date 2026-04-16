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
                                    class="px-4 py-2 border rounded-lg text-sm bg-indigo-600 hover:bg-indigo-700 text-white">
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
    // Validasi untuk field quantity
    const quantityInput = document.querySelector('input[name="quantity"]');
    if (quantityInput) {
        quantityInput.addEventListener('input', function(e) {
            // Hapus semua karakter non-angka
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Tampilkan pesan error jika ada input invalid
            if (this.value && this.value !== this.value.replace(/[^0-9]/g, '')) {
                showError(this, 'Input tidak valid. Hanya angka yang diperbolehkan pada field ini.');
            } else {
                hideError(this);
            }
        });
        
        quantityInput.addEventListener('keypress', function(e) {
            // Mencegah input karakter non-angka
            const char = String.fromCharCode(e.which);
            if (!/[0-9]/.test(char)) {
                e.preventDefault();
                showError(this, 'Input tidak valid. Hanya angka yang diperbolehkan pada field ini.');
            }
        });
    }
    
    // Validasi untuk field price
    const priceInput = document.querySelector('input[name="price"]');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9,.]/g, '');
            
            // Parse Indonesian format: remove thousand dots, comma → dot decimal
            value = value.replace(/\./g, '').replace(/,/g, '.');
            
            // Ensure only one decimal point
            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }
            
            this.value = value;
            
            if (value && !/^[0-9]*\.?[0-9]*$/.test(value)) {
                showError(this, 'Format harga tidak valid. Gunakan angka atau 1.000.000,50');
            } else {
                hideError(this);
            }
        });
        
        priceInput.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[0-9,.]/.test(char)) {
                e.preventDefault();
            }
        });
    }
    
    function showError(input, message) {
        // Remove existing error
        hideError(input);
        
        // Create error element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'mt-1.5 text-xs text-red-500 real-time-error';
        errorDiv.textContent = message;
        
        // Insert error after input
        input.parentNode.appendChild(errorDiv);
        
        // Add red border to input
        input.classList.add('border-red-400');
        input.classList.remove('border-gray-300');
    }
    
    function hideError(input) {
        // Remove existing error
        const existingError = input.parentNode.querySelector('.real-time-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Restore normal border
        input.classList.remove('border-red-400');
        input.classList.add('border-gray-300');
    }
});
</script>
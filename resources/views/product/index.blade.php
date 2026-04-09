<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                                Product List
                            </h2>
                            <p class="text-sm text-gray-400 mt-1">
                                Manage your product inventory
                            </p>
                        </div>

                        <a href="{{ route('product.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition duration-150 shadow-sm">
                            Add Product
                        </a>
                    </div>

                    <!-- Flash Message -->
                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">#</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase">Owner</th>
                                    <th class="px-6 py-3 text-center font-semibold text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @forelse($products as $product)
                                    <tr class="hover:bg-gray-50 transition duration-100">
                                        <td class="px-6 py-4">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-6 py-4 font-medium">
                                            {{ $product->name }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $product->quantity > 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->quantity }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $product->user->name ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">

                                                <!-- View -->
                                                <a href="{{ route('product.show', $product->id) }}"
                                                   class="text-blue-500 hover:text-blue-700">
                                                    View
                                                </a>

                                                <!-- Edit -->
                                                <a href="{{ route('product.edit', $product) }}"
                                                   class="text-yellow-500 hover:text-yellow-700">
                                                    Edit
                                                </a>

                                                <!-- Delete -->
                                                <form action="{{ route('product.delete', $product->id) }}" method="POST"
                                                      onsubmit="return confirm('Delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-500 hover:text-red-700">
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            No products found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
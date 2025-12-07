@extends('layouts.vendor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-secondary-800">Inventory</h1>
            <p class="text-gray-600 mt-1">Manage your product inventory</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <p class="text-sm text-gray-600">Total Products</p>
            <p class="text-2xl font-bold text-secondary-800 mt-1">{{ $stats['total_products'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <p class="text-sm text-gray-600">In Stock</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['in_stock'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <p class="text-sm text-gray-600">Low Stock</p>
            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['low_stock'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <p class="text-sm text-gray-600">Out of Stock</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['out_of_stock'] }}</p>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
        <form action="{{ route('vendor.inventory') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" id="search" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" value="{{ request('search') }}" placeholder="Product name or SKU">
                </div>
                <div>
                    <label for="stock_status" class="block text-sm font-medium text-gray-700">Stock Status</label>
                    <select name="stock_status" id="stock_status" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full justify-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->sku }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" value="{{ $product->stock_quantity }}" class="w-24 text-center rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 stock-input" data-product-id="{{ $product->id }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->stock_quantity > 10)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In Stock</span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Low Stock</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12">
                                <p class="text-gray-600">No products found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-gray-200">
            {{ $products->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.stock-input').forEach(input => {
        input.addEventListener('change', async (e) => {
            const productId = e.target.dataset.productId;
            const stockQuantity = e.target.value;

            try {
                const response = await fetch(`/vendor/inventory/${productId}/stock`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ stock_quantity: stockQuantity })
                });

                if (!response.ok) {
                    throw new Error('Failed to update stock');
                }

                const result = await response.json();
                // You can add a success notification here
            } catch (error) {
                console.error('Error updating stock:', error);
                // You can add an error notification here
            }
        });
    });
</script>
@endpush
@endsection

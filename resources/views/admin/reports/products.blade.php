<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500">Total Products Sold</h4>
        <p class="text-2xl font-semibold text-gray-900">{{ $data['total_products_sold'] }}</p>
    </div>
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500">Total Revenue from Products</h4>
        <p class="text-2xl font-semibold text-gray-900">₦{{ number_format($data['total_revenue'], 2) }}</p>
    </div>
</div>

<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units Sold</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Revenue</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($data['products'] as $product)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->units_sold }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₦{{ number_format($product->revenue, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

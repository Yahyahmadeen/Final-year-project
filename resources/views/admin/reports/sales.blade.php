<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500">Total Revenue</h4>
        <p class="text-2xl font-semibold text-gray-900">₦{{ number_format($data['total_revenue'], 2) }}</p>
    </div>
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500">Total Orders</h4>
        <p class="text-2xl font-semibold text-gray-900">{{ $data['total_orders'] }}</p>
    </div>
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500">Average Order Value</h4>
        <p class="text-2xl font-semibold text-gray-900">₦{{ number_format($data['average_order_value'], 2) }}</p>
    </div>
</div>

<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($data['orders'] as $order)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₦{{ number_format($order->total_amount, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@extends('layouts.admin')

@section('title', 'Vendor Payout Requests')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Vendor Payout Requests</h1>
    
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">All Payout Requests</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.payouts.index', ['status' => 'pending']) }}" 
                       class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors">
                        Pending
                    </a>
                    <a href="{{ route('admin.payouts.index', ['status' => 'completed']) }}" 
                       class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                        completed
                    </a>
                    <a href="{{ route('admin.payouts.index', ['status' => 'rejected']) }}" 
                       class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                        Rejected
                    </a>
                    <a href="{{ route('admin.payouts.index') }}" 
                       class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                        All
                    </a>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payouts as $payout)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payout->reference }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $payout->vendor->store_name ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                            ₦{{ number_format($payout->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $payout->bank_name }}<br>
                            <span class="text-xs">{{ substr($payout->account_number, 0, 3) }}****{{ substr($payout->account_number, -3) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $payout->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($payout->status === 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($payout->status === 'completed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @elseif($payout->status === 'rejected')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="{{ route('admin.payouts.show', $payout) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            
                            @if($payout->status === 'pending')
                                <button onclick="document.getElementById('approve-modal-{{ $payout->id }}').classList.remove('hidden')" 
                                        class="text-green-600 hover:text-green-900 mr-3">
                                    Approve
                                </button>
                                <button onclick="document.getElementById('reject-modal-{{ $payout->id }}').classList.remove('hidden')" 
                                        class="text-red-600 hover:text-red-900">
                                    Reject
                                </button>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Approve Modal -->
                    <div id="approve-modal-{{ $payout->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                            <div class="mt-3 text-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Approve Payout</h3>
                                <div class="mt-2 px-7 py-3">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to approve this payout request?<br>
                                        <strong>₦{{ number_format($payout->amount, 2) }}</strong> will be sent to vendor.
                                    </p>
                                    
                                    <form action="{{ route('admin.payouts.approve', $payout) }}" method="POST" class="mt-4">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 text-left mb-2">Admin Notes (Optional)</label>
                                            <textarea name="admin_notes" rows="2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                                        </div>
                                        
                                        <div class="flex justify-between mt-4">
                                            <button type="button" onclick="document.getElementById('approve-modal-{{ $payout->id }}').classList.add('hidden')" 
                                                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Cancel
                                            </button>
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Confirm Approval
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reject Modal -->
                    <div id="reject-modal-{{ $payout->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                            <div class="mt-3 text-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Payout</h3>
                                <div class="mt-2 px-7 py-3">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to reject this payout request?<br>
                                        <strong>₦{{ number_format($payout->amount, 2) }}</strong> will be refunded to vendor's wallet.
                                    </p>
                                    
                                    <form action="{{ route('admin.payouts.reject', $payout) }}" method="POST" class="mt-4">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 text-left mb-2">Reason for Rejection (Required)</label>
                                            <textarea name="admin_notes" rows="3" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                                        </div>
                                        
                                        <div class="flex justify-between mt-4">
                                            <button type="button" onclick="document.getElementById('reject-modal-{{ $payout->id }}').classList.add('hidden')" 
                                                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Cancel
                                            </button>
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Confirm Rejection
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No payout requests found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50">
            {{ $payouts->links() }}
        </div>
    </div>
</div>
@endsection

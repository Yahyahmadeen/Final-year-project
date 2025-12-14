@extends('layouts.admin')

@section('title', 'Payout Request Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.payouts.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Payout Requests
        </a>
    </div>
    
    <h1 class="text-3xl font-bold mb-6">Payout Request Details</h1>
    
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
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Payout Details -->
        <div class="md:col-span-2 bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Payout Information</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Reference</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $payout->reference }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <p class="mt-1">
                            @if($payout->status === 'pending')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($payout->status === 'approved')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Approved
                                </span>
                            @elseif($payout->status === 'rejected')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Amount</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">₦{{ number_format($payout->amount, 2) }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Date Requested</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->created_at->format('F j, Y g:i A') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Payment Method</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->payment_method }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Bank Name</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->bank_name }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Account Number</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->account_number }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Account Name</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->account_name }}</p>
                    </div>
                    
                    @if($payout->processed_at)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Processed Date</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->processed_at->format('F j, Y g:i A') }}</p>
                    </div>
                    @endif
                    
                    @if($payout->notes)
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-medium text-gray-500">Vendor Notes</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->notes }}</p>
                    </div>
                    @endif
                    
                    @if($payout->admin_notes)
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-medium text-gray-500">Admin Notes</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->admin_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Vendor Information -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Vendor Information</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Store Name</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $payout->vendor->store_name }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Vendor ID</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->vendor->id }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Email</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->vendor->email }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                        <p class="mt-1 text-gray-900">{{ $payout->vendor->phone }}</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900">View Vendor Profile</a>
                </div>
                
                @if($payout->status === 'pending')
                <div class="mt-8 space-y-4">
                    <button onclick="document.getElementById('approve-modal').classList.remove('hidden')" 
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Approve Payout
                    </button>
                    
                    <button onclick="document.getElementById('reject-modal').classList.remove('hidden')" 
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Reject Payout
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Approve Modal -->
    <div id="approve-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
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
                            <button type="button" onclick="document.getElementById('approve-modal').classList.add('hidden')" 
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
    <div id="reject-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
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
                            <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" 
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
</div>
@endsection

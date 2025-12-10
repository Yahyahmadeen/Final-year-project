@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Edit User')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Edit User Information</h2>
            <p class="text-sm text-gray-500 mt-1">Update user details, role, and status</p>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           required>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">User Role</label>
                    <select name="role" id="role" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required>
                        <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="vendor" {{ old('role', $user->role) === 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Select the user's role in the system</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                    <select name="status" id="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required>
                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ old('status', $user->status) === 'inactive' ? 'pending' : '' }}>Inactive</option>
                        <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Control user's access to the platform</p>
                </div>

                <!-- Additional Info (Read-only) -->
                <div class="border-t pt-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-4">Account Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">User ID:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $user->id }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Joined:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Last Updated:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $user->updated_at->format('M d, Y') }}</span>
                        </div>
                        @if($user->wallet)
                        <div>
                            <span class="text-gray-500">Wallet Balance:</span>
                            <span class="ml-2 font-medium text-gray-900">₦{{ number_format($user->wallet->balance, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t">
                    <a href="{{ route('admin.users') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                        Update User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

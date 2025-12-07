@extends('layouts.user')

@section('header', 'My Addresses')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-medium text-gray-900">Saved Addresses</h2>
        <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="hi-outline hi-plus -ml-1 mr-2 h-5 w-5"></i>
            Add New Address
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="hi-solid hi-check-circle h-5 w-5 text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if ($addresses->isEmpty())
        <div class="text-center py-12">
            <i class="hi-outline hi-map h-12 w-12 mx-auto text-gray-400"></i>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No addresses saved</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by adding a new address.</p>
            <div class="mt-6">
                <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="hi-outline hi-plus -ml-1 mr-2 h-5 w-5"></i>
                    Add New Address
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($addresses as $address)
                <div class="relative bg-white border rounded-lg p-6 shadow-sm">
                    @if ($address->is_default)
                        <div class="absolute top-2 right-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                Default
                            </span>
                        </div>
                    @endif
                    
                    <div class="space-y-1">
                        <h4 class="text-lg font-medium text-gray-900">{{ $address->first_name }} {{ $address->last_name }}</h4>
                        
                        @if ($address->company)
                            <p class="text-sm text-gray-500">{{ $address->company }}</p>
                        @endif
                        
                        <p class="text-sm text-gray-700">
                            {{ $address->address_line_1 }}<br>
                            @if ($address->address_line_2)
                                {{ $address->address_line_2 }}<br>
                            @endif
                            {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br>
                            {{ $address->country }}
                        </p>
                        
                        <p class="text-sm text-gray-700 mt-2">
                            <i class="hi-outline hi-phone mr-1"></i> {{ $address->phone }}
                        </p>
                    </div>
                    
                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('addresses.edit', $address) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            Edit
                        </a>
                        <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this address?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                Delete
                            </button>
                        </form>
                        @if (!$address->is_default)
                            <form action="{{ route('addresses.set-default', $address) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                    Set as Default
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@extends('layouts.user')

@section('header', 'Edit Address')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('addresses.update', $address) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Address</h3>
                        <p class="mt-1 text-sm text-gray-500">Update your delivery address details.</p>
                    </div>

                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="hi-solid hi-x-circle h-5 w-5 text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        There {{ $errors->count() === 1 ? 'is' : 'are' }} {{ $errors->count() }} {{ Str::plural('error', $errors->count()) }} with your submission
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $address->first_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-3">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $address->last_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-6">
                            <label for="company" class="block text-sm font-medium text-gray-700">Company (Optional)</label>
                            <input type="text" name="company" id="company" value="{{ old('company', $address->company) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-6">
                            <label for="address_line_1" class="block text-sm font-medium text-gray-700">Address line 1</label>
                            <input type="text" name="address_line_1" id="address_line_1" value="{{ old('address_line_1', $address->address_line_1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-6">
                            <label for="address_line_2" class="block text-sm font-medium text-gray-700">Address line 2 (Optional)</label>
                            <input type="text" name="address_line_2" id="address_line_2" value="{{ old('address_line_2', $address->address_line_2) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $address->city) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="state" class="block text-sm font-medium text-gray-700">State / Province</label>
                            <input type="text" name="state" id="state" value="{{ old('state', $address->state) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">ZIP / Postal code</label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $address->postal_code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-3">
                            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                            <select id="country" name="country" class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select a country</option>
                                <option value="United States" {{ (old('country', $address->country) == 'United States') ? 'selected' : '' }}>United States</option>
                                <option value="Canada" {{ (old('country', $address->country) == 'Canada') ? 'selected' : '' }}>Canada</option>
                                <option value="Mexico" {{ (old('country', $address->country) == 'Mexico') ? 'selected' : '' }}>Mexico</option>
                                <option value="United Kingdom" {{ (old('country', $address->country) == 'United Kingdom') ? 'selected' : '' }}>United Kingdom</option>
                                <option value="Nigeria" {{ (old('country', $address->country) == 'Nigeria') ? 'selected' : '' }}>Nigeria</option>
                                <option value="Ghana" {{ (old('country', $address->country) == 'Ghana') ? 'selected' : '' }}>Ghana</option>
                                <option value="South Africa" {{ (old('country', $address->country) == 'South Africa') ? 'selected' : '' }}>South Africa</option>
                                <option value="Kenya" {{ (old('country', $address->country) == 'Kenya') ? 'selected' : '' }}>Kenya</option>
                                <option value="Other" {{ (old('country', $address->country) == 'Other') ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $address->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-6">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="is_default" name="is_default" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_default" class="font-medium text-gray-700">Set as default address</label>
                                    <p class="text-gray-500">Use this as my default shipping and billing address.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('addresses.index') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Update Address
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

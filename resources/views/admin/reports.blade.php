@extends('layouts.admin')

@section('title', 'Reports')
@section('page_title', 'Reports')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Generate Report</h2>

    <form action="{{ route('admin.reports') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="report_type" class="block text-sm font-medium text-gray-700">Report Type</label>
                <select id="report_type" name="report_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                    <option value="sales" {{ request('report_type') == 'sales' ? 'selected' : '' }}>Sales</option>
                    <option value="users" {{ request('report_type') == 'users' ? 'selected' : '' }}>Users</option>
                    <option value="products" {{ request('report_type') == 'products' ? 'selected' : '' }}>Products</option>
                </select>
            </div>
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full pl-3 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full pl-3 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Generate</button>
        </div>
    </form>
</div>

@if(isset($reportData))
<div class="mt-8 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Report Results</h3>
    @if($reportType == 'sales')
        @include('admin.reports.sales', ['data' => $reportData])
    @elseif($reportType == 'users')
        @include('admin.reports.users', ['data' => $reportData])
    @elseif($reportType == 'products')
        @include('admin.reports.products', ['data' => $reportData])
    @endif
</div>
@endif
@endsection

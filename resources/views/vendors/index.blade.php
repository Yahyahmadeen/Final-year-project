@extends('layouts.app')

@section('header', 'Our Vendors')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">Our Trusted Vendors</h1>
        <p class="mt-4 text-lg text-gray-600">Discover amazing products from our verified vendors</p>
    </div>

    <!-- Vendors Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($vendors as $vendor)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16 rounded-full overflow-hidden bg-gray-100">
                            @if($vendor->logo)
                                <img src="{{ $vendor->logo }}" alt="{{ $vendor->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-primary-100 text-primary-600 font-semibold text-xl">
                                    {{ strtoupper(substr($vendor->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $vendor->name }}</h3>
                            @if($vendor->reviews_avg_rating)
                                <div class="flex items-center mt-1">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($vendor->reviews_avg_rating))
                                                <i class="hi-solid hi-star h-4 w-4 text-yellow-400"></i>
                                            @elseif($i == ceil($vendor->reviews_avg_rating) && $vendor->reviews_avg_rating - floor($vendor->reviews_avg_rating) >= 0.5)
                                                <i class="hi-solid hi-star-half h-4 w-4 text-yellow-400"></i>
                                            @else
                                                <i class="hi-outline hi-star h-4 w-4 text-yellow-400"></i>
                                            @endif
                                        @endfor
                                        <span class="ml-1 text-sm text-gray-500">{{ number_format($vendor->reviews_avg_rating, 1) }}</span>
                                    </div>
                                    <span class="mx-1 text-gray-300">•</span>
                                    <span class="text-sm text-gray-500">{{ $vendor->products_count ?? 0 }} products</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($vendor->description)
                        <p class="mt-3 text-sm text-gray-600 line-clamp-2">{{ $vendor->description }}</p>
                    @endif
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('vendors.show', $vendor) }}" class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-500">
                            View Store
                            <i class="hi-outline hi-arrow-right ml-1 h-4 w-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 mb-4">
                    <i class="hi-outline hi-truck h-8 w-8 text-primary-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No vendors found</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for new vendors.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($vendors->hasPages())
        <div class="mt-10">
            {{ $vendors->links() }}
        </div>
    @endif
</div>
@endsection

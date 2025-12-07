@extends('layouts.app')

@section('header', $vendor->name)

@section('content')
<div class="bg-white">
    <!-- Vendor Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center">
                <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-8">
                    @if($vendor->logo)
                        <img class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-lg" 
                             src="{{ $vendor->logo }}" 
                             alt="{{ $vendor->name }} logo">
                    @else
                        <div class="h-32 w-32 rounded-full bg-white flex items-center justify-center text-4xl font-bold text-primary-600 border-4 border-white shadow-lg">
                            {{ strtoupper(substr($vendor->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-3xl font-bold text-white">{{ $vendor->name }}</h1>
                    @if($vendor->description)
                        <p class="mt-2 text-primary-100 max-w-2xl">{{ $vendor->description }}</p>
                    @endif
                    
                    <div class="mt-4 flex flex-wrap items-center justify-center md:justify-start space-x-6">
                        @if($vendor->reviews_avg_rating)
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($vendor->reviews_avg_rating))
                                            <i class="hi-solid hi-star h-5 w-5 text-yellow-400"></i>
                                        @elseif($i == ceil($vendor->reviews_avg_rating) && $vendor->reviews_avg_rating - floor($vendor->reviews_avg_rating) >= 0.5)
                                            <i class="hi-solid hi-star-half h-5 w-5 text-yellow-400"></i>
                                        @else
                                            <i class="hi-outline hi-star h-5 w-5 text-yellow-400"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm font-medium text-white">
                                    {{ number_format($vendor->reviews_avg_rating, 1) }} ({{ $vendor->reviews_count ?? 0 }} reviews)
                                </span>
                            </div>
                        @endif
                        
                        <div class="flex items-center text-sm text-white">
                            <i class="hi-outline hi-shopping-bag h-5 w-5 mr-1"></i>
                            <span>{{ $vendor->products_count ?? 0 }} products</span>
                        </div>
                        
                        @if($vendor->location)
                            <div class="flex items-center text-sm text-white">
                                <i class="hi-outline hi-location-marker h-5 w-5 mr-1"></i>
                                <span>{{ $vendor->location }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters and Sorting -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <!-- Category Filter -->
            <div class="mb-4 md:mb-0">
                <label for="category" class="sr-only">Category</label>
                <select id="category" 
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->products_count ?? 0 }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Sort By -->
            <div class="flex items-center">
                <label for="sort" class="mr-2 text-sm font-medium text-gray-700">Sort by:</label>
                <select id="sort" 
                        class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="group bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300 border border-gray-100">
                        <!-- Product Image -->
                        <div class="relative pt-[100%] bg-gray-50">
                            @php
                                $images = $product->images;
                                $mainImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                            @endphp
                            
                            @if($mainImage)
                                <img src="{{ $mainImage }}" 
                                     alt="{{ $product->name }}" 
                                     class="absolute inset-0 w-full h-full object-cover group-hover:opacity-90 transition-opacity duration-300">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400">
                                    <i class="hi-outline hi-photo h-12 w-12"></i>
                                </div>
                            @endif
                            
                            <!-- Wishlist Button -->
                            <button type="button" 
                                    class="absolute top-3 right-3 p-2 rounded-full bg-white/80 backdrop-blur-sm text-gray-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    data-product-id="{{ $product->id }}">
                                <i class="{{ in_array($product->id, $wishlist) ? 'hi-solid hi-heart text-red-500' : 'hi-outline hi-heart' }} h-5 w-5"></i>
                                <span class="sr-only">Add to wishlist</span>
                            </button>
                            
                            <!-- Sale Badge -->
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                    {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Details -->
                        <div class="p-4">
                            <!-- Category -->
                            @if($product->category)
                                <p class="text-xs font-medium text-primary-600 mb-1">{{ $product->category->name }}</p>
                            @endif
                            
                            <!-- Title -->
                            <h3 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2">
                                <a href="{{ route('products.show', $product) }}" class="hover:text-primary-600">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            
                            <!-- Rating -->
                            @if($product->reviews_avg_rating)
                                <div class="flex items-center mt-1 mb-2">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->reviews_avg_rating))
                                                <i class="hi-solid hi-star h-3.5 w-3.5 text-yellow-400"></i>
                                            @elseif($i == ceil($product->reviews_avg_rating) && $product->reviews_avg_rating - floor($product->reviews_avg_rating) >= 0.5)
                                                <i class="hi-solid hi-star-half h-3.5 w-3.5 text-yellow-400"></i>
                                            @else
                                                <i class="hi-outline hi-star h-3.5 w-3.5 text-yellow-400"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="ml-1 text-xs text-gray-500">({{ $product->reviews_count ?? 0 }})</span>
                                </div>
                            @endif
                            
                            <!-- Price -->
                            <div class="mt-2 flex items-center justify-between">
                                <div>
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <p class="text-lg font-bold text-gray-900">₦{{ number_format($product->sale_price, 2) }}</p>
                                        <p class="text-xs text-gray-500 line-through">₦{{ number_format($product->price, 2) }}</p>
                                    @else
                                        <p class="text-lg font-bold text-gray-900">₦{{ number_format($product->price, 2) }}</p>
                                    @endif
                                </div>
                                
                                <!-- Add to Cart Button -->
                                <button type="button" 
                                        class="p-2 rounded-full bg-primary-600 text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                        data-product-id="{{ $product->id }}">
                                    <i class="hi-outline hi-shopping-cart h-5 w-5"></i>
                                    <span class="sr-only">Add to cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-10">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
            
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 mb-4">
                    <i class="hi-outline hi-exclamation-circle h-8 w-8 text-primary-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">This vendor doesn't have any products available at the moment.</p>
                <div class="mt-6">
                    <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Continue Shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Handle category filter change
    document.getElementById('category').addEventListener('change', function() {
        const categoryId = this.value;
        const url = new URL(window.location.href);
        
        if (categoryId) {
            url.searchParams.set('category_id', categoryId);
        } else {
            url.searchParams.delete('category_id');
        }
        
        window.location.href = url.toString();
    });
    
    // Handle sort change
    document.getElementById('sort').addEventListener('change', function() {
        const sort = this.value;
        const url = new URL(window.location.href);
        
        if (sort && sort !== 'newest') {
            url.searchParams.set('sort', sort);
        } else {
            url.searchParams.delete('sort');
        }
        
        window.location.href = url.toString();
    });
    
    // Handle wishlist toggle
    document.querySelectorAll('[data-product-id]').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');
            
            try {
                const response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Toggle icon
                    if (icon.classList.contains('hi-outline')) {
                        icon.classList.remove('hi-outline');
                        icon.classList.add('hi-solid', 'text-red-500');
                    } else {
                        icon.classList.remove('hi-solid', 'text-red-500');
                        icon.classList.add('hi-outline');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
</script>
@endpush
@endsection

@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Category Header -->
        <div class="py-8">
            <nav aria-label="Breadcrumb" class="mb-4">
                <ol role="list" class="flex items-center space-x-2">
                    <li>
                        <div class="flex items-center">
                            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Home</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="{{ route('categories.index') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Categories</a>
                        </div>
                    </li>
                    @if($category->parent)
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="{{ route('categories.show', $category->parent->slug) }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $category->parent->name }}</a>
                        </div>
                    </li>
                    @endif
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 text-sm font-medium text-gray-500">{{ $category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
            @if($category->description)
                <p class="mt-2 text-gray-600">{{ $category->description }}</p>
            @endif
        </div>

        <!-- Subcategories -->
        @if($subcategories->count() > 0)
            <div class="mb-8">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Subcategories</h2>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                    @foreach($subcategories as $subcategory)
                        <a href="{{ route('categories.show', $subcategory->slug) }}" class="group relative bg-white border border-gray-200 rounded-lg p-4 flex flex-col items-center text-center hover:border-gray-300 focus:outline-none">
                            <span class="mt-2 block text-sm font-medium text-gray-900 group-hover:text-primary-600">
                                {{ $subcategory->name }}
                            </span>
                            <span class="mt-1 text-sm text-gray-500">
                                {{ $subcategory->products_count }} {{ Str::plural('product', $subcategory->products_count) }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Filters and Sorting -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
            <!-- Search -->
            <div class="w-full md:w-1/3">
                <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="flex">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search products..." 
                           class="flex-1 min-w-0 block w-full px-3 py-2 rounded-l-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Sort -->
            <div class="w-full md:w-auto">
                <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="flex items-center space-x-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <label for="sort" class="text-sm font-medium text-gray-700">Sort by:</label>
                    <select id="sort" 
                            name="sort" 
                            onchange="this.form.submit()"
                            class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Price Filter -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-sm font-medium text-gray-900 mb-4">Price Range</h3>
            <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="grid grid-cols-2 gap-4">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <div>
                    <label for="min_price" class="block text-sm font-medium text-gray-700">Min Price</label>
                    <input type="number" 
                           name="min_price" 
                           id="min_price" 
                           value="{{ request('min_price') }}" 
                           placeholder="Min"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                </div>
                <div>
                    <label for="max_price" class="block text-sm font-medium text-gray-700">Max Price</label>
                    <input type="number" 
                           name="max_price" 
                           id="max_price" 
                           value="{{ request('max_price') }}" 
                           placeholder="Max"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                </div>
                <div class="col-span-2">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Apply Filters
                    </button>
                </div>
                @if(request('min_price') || request('max_price'))
                <div class="col-span-2">
                    <a href="{{ route('categories.show', $category->slug) }}" class="text-sm text-primary-600 hover:text-primary-700">
                        Clear filters
                    </a>
                </div>
                @endif
            </form>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                @foreach($products as $product)
                    <div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                            <a href="{{ route('products.show', $product->slug) }}" class="group">
                                @if($product->images?->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="h-48 w-full object-cover object-center group-hover:opacity-75">
                                @else
                                    <div class="h-48 w-full flex items-center justify-center bg-gray-200">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    SALE
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $product->category->name }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <p class="text-sm font-medium text-gray-900">
                                            ₦{{ number_format($product->sale_price, 2) }}
                                        </p>
                                        <p class="text-xs text-gray-500 line-through">
                                            ₦{{ number_format($product->price, 2) }}
                                        </p>
                                    @else
                                        <p class="text-sm font-medium text-gray-900">
                                            ₦{{ number_format($product->price, 2) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->average_rating))
                                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @elseif($i == ceil($product->average_rating) && $product->average_rating - floor($product->average_rating) > 0)
                                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half-star" x1="0" x2="50%" y1="0" y2="0">
                                                        <stop offset="50%" stop-color="#F59E0B" />
                                                        <stop offset="50%" stop-color="#E5E7EB" />
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="ml-1 text-xs text-gray-500">
                                        ({{ $product->reviews_count }})
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">We couldn't find any products matching your criteria.</p>
                <div class="mt-6">
                    <a href="{{ route('categories.show', $category->slug) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Clear filters
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

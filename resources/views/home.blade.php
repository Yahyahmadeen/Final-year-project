@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Welcome to</span>
                        <span class="block text-primary-600 xl:inline">eProShop</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Discover amazing products at the best prices. Shop now and enjoy a seamless shopping experience.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start
                    ">
                        <div class="rounded-md shadow">
                            <a href="{{ route('shop') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 md:py-4 md:text-lg md:px-10">
                                Shop Now
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="#featured" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200 md:py-4 md:text-lg md:px-10">
                                Featured Products
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2850&q=80" alt="">
    </div>
</div>

<!-- Featured Products -->
<div id="featured" class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Featured Products
            </h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Check out our handpicked selection of featured products
            </p>
        </div>

        <div class="mt-10">
            @if($featuredProducts->count() > 0)
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @foreach($featuredProducts as $product)
                        <div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                <a href="{{ route('products.show', $product->slug) }}" class="group">
                                    @if(!empty($product->images) && count($product->images) > 0)
                                        @php $firstImage = is_array($product->images) ? $product->images[0] : $product->images; @endphp
                                        <img src="{{ asset('storage/' . (is_object($firstImage) ? $firstImage->path : $firstImage)) }}" 
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
                                <h3 class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $product->category->name }}
                                </p>
                                <div class="mt-2 flex justify-between items-center">
                                    <div>
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
                                    <form action="{{ route('cart.add') }}" method="POST" class="ml-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="text-primary-600 hover:text-primary-700">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700">
                        View All Products
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No featured products</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for our featured products.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Categories -->
@if($categories->count() > 0)
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Shop by Category
            </h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Browse our wide selection of products by category
            </p>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($categories->take(8) as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="h-48 w-full object-cover object-center group-hover:opacity-75">
                        @else
                            <div class="h-48 w-full flex items-center justify-center bg-gray-100">
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900">
                            {{ $category->name }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
        
        @if($categories->count() > 8)
            <div class="mt-10 text-center">
                <a href="{{ route('categories.index') }}" class="text-primary-600 hover:text-primary-500 font-medium">
                    View all categories
                    <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endif

<!-- Featured Vendors -->
@if($vendors->count() > 0)
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Our Sellers
            </h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Shop from our trusted sellers
            </p>
        </div>

        <div class="mt-10
        ">
            <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($vendors as $vendor)
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gray-200 overflow-hidden">
                                    @if($vendor->logo)
                                        <img src="{{ asset('storage/' . $vendor->logo) }}" alt="{{ $vendor->business_name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-gray-100">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('vendors.show', $vendor->slug) }}">
                                            {{ $vendor->business_name }}
                                        </a>
                                    </h3>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($vendor->average_rating))
                                                <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endif
                                        @endfor
                                        <span class="ml-1 text-xs text-gray-500">({{ $vendor->products_count }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-10 text-center">
                <a href="{{ route('vendors.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700">
                    View All Sellers
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Call to Action -->
<div class="bg-primary-700">
    <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
            <span class="block">Ready to start shopping?</span>
            <span class="block">Start exploring our products today.</span>
        </h2>
        <p class="mt-4 text-lg leading-6 text-primary-200">
            Join thousands of satisfied customers who trust us for quality products and excellent service.
        </p>
        <a href="{{ route('shop') }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary-600 bg-white hover:bg-primary-50 sm:w-auto">
            Shop Now
        </a>
    </div>
</div>
@endsection

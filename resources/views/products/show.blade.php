@extends('layouts.app')

@push('styles')
    <style>
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-in-out forwards;
        }

        .animate-fade-out {
            animation: fadeOut 0.3s ease-in-out forwards;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush


@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center space-x-2 text-sm">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">Home</a>
                    <span class="text-gray-400">/</span>
                    <a href="{{ route('shop') }}" class="text-gray-500 hover:text-primary-600">Shop</a>
                    <span class="text-gray-400">/</span>
                    <a href="{{ route('categories.show', $product->category->slug) }}"
                        class="text-gray-500 hover:text-primary-600">
                        {{ $product->category->name }}
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-secondary-800 font-medium">{{ $product->name }}</span>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                <!-- Product Images Section -->
                <div class="sticky top-8">
                    <div class="space-y-4">
                        <!-- Main Image -->
                        <div class="relative">
                            <div
                                class="aspect-square bg-white rounded-3xl shadow-xl border border-gray-100 flex items-center justify-center overflow-hidden group">
                                @if ($product->imagesFirst && count($product->imagesFirst) > 0)
                                    @php
                                        $primaryImage =
                                            collect($product->imagesFirst)->where('is_primary', 1)->first() ??
                                            collect($product->imagesFirst)->first();
                                    @endphp
                                    <img id="main-image" src="{{ asset('storage/' . $primaryImage['path']) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="flex flex-col items-center justify-center text-gray-400 p-12">
                                        <div
                                            class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-lg font-medium text-gray-500">No Image Available</p>
                                        <p class="text-sm text-gray-400 mt-1">Product image will appear here</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Image Counter Badge -->
                            @if ($product->imagesFirst && count($product->imagesFirst) > 1)
                                <div
                                    class="absolute top-4 right-4 bg-black bg-opacity-60 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    1 / {{ count($product->imagesFirst) }}
                                </div>
                            @endif
                        </div>

                        <!-- Thumbnail Images -->
                        @if ($product->imagesFirst && count($product->imagesFirst) > 1)
                            <div class="grid grid-cols-5 gap-3">
                                @foreach ($product->imagesFirst as $index => $image)
                                    <button
                                        onclick="changeMainImage('{{ asset('storage/' . $image['path']) }}', {{ $index + 1 }})"
                                        class="thumbnail-btn aspect-square bg-white rounded-xl border-2 flex items-center justify-center overflow-hidden transition-all hover:shadow-lg {{ $index === 0 ? 'border-primary-500 ring-2 ring-primary-200' : 'border-gray-200 hover:border-primary-300' }}">
                                        <img src="{{ asset('storage/' . $image['path']) }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Information Section -->
                <div class="space-y-8">
                    <!-- Breadcrumb & Back Button -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('shop') }}"
                            class="inline-flex items-center text-gray-600 hover:text-primary-600 transition-colors bg-gray-50 hover:bg-gray-100 px-4 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back to Shop
                        </a>

                        <!-- Wishlist & Share Buttons -->
                        <div class="flex items-center space-x-2">
                            <button id="wishlist-btn"
                                class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Product Title & Vendor -->
                    <div class="space-y-3">
                        <div class="flex items-center space-x-2 text-sm">
                            <span
                                class="bg-primary-100 text-primary-800 px-3 py-1 rounded-full font-medium">{{ $product->category->name }}</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">SKU: {{ $product->sku }}</span>
                        </div>
                        <h1 class="text-4xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h1>
                        <div class="flex items-center space-x-3">
                            <a href="#" class="text-primary-600 hover:text-primary-700 font-semibold text-lg">
                                {{ $product->vendor->store_name ?? $product->vendor->name }}
                            </a>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Verified
                                Seller</span>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($product->average_rating))
                                    <svg class="h-5 w-5 text-yellow-400 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-gray-600">
                            {{ number_format($product->average_rating, 1) }} ({{ $product->reviews_count ?? 0 }} reviews)
                        </span>
                    </div>

                    <!-- Price Section -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Price</h3>
                            @if ($product->sale_price && $product->sale_price < $product->price)
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                                    SAVE
                                    {{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%
                                </span>
                            @endif
                        </div>
                        <div class="flex items-baseline space-x-3">
                            <span class="text-4xl font-bold text-primary-600">
                                ₦{{ number_format($product->sale_price ?? $product->price, 0) }}
                            </span>
                            @if ($product->sale_price && $product->sale_price < $product->price)
                                <span class="text-xl text-gray-500 line-through">
                                    ₦{{ number_format($product->price, 0) }}
                                </span>
                                <span class="text-green-600 font-semibold">
                                    You save ₦{{ number_format($product->price - $product->sale_price, 0) }}
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Inclusive of all taxes • Free shipping on orders over ₦50,000
                        </p>
                    </div>

                    <!-- Stock Status -->
                    <div class="flex items-center space-x-2">
                        @if ($product->stock_quantity > 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-green-700 font-medium">In Stock</span>
                            @if ($product->stock_quantity <= 10)
                                <span class="text-orange-600 text-sm">
                                    (Only {{ $product->stock_quantity }} left)
                                </span>
                            @endif
                        @else
                            <div class="h-5 w-5 bg-red-500 rounded-full"></div>
                            <span class="text-red-700 font-medium">Out of Stock</span>
                        @endif
                    </div>


                    <!-- Purchase Section -->
                    @if ($product->stock_quantity > 0 && $product->status === 'published')
                        <div class="bg-white border-2 border-primary-200 rounded-2xl p-6 space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Purchase Options
                            </h3>

                            <!-- Quantity Selector -->
                            <div class="space-y-3">
                                <label class="text-sm font-medium text-gray-700 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    Quantity
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="flex items-center border-2 border-gray-300 rounded-xl overflow-hidden bg-white shadow-sm">
                                        <button type="button" data-action="decrement"
                                            class="px-4 py-3 text-gray-600 hover:bg-gray-100 transition-all font-semibold hover:text-primary-600 active:bg-gray-200"
                                            title="Decrease quantity">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input type="number" id="quantity" value="1" min="1"
                                            max="{{ min(10, $product->stock_quantity) }}"
                                            class="w-20 text-center border-0 focus:ring-0 py-3 font-bold text-lg text-gray-800 bg-gray-50"
                                            readonly>
                                        <button type="button" data-action="increment"
                                            class="px-4 py-3 text-gray-600 hover:bg-gray-100 transition-all font-semibold hover:text-primary-600 active:bg-gray-200"
                                            title="Increase quantity">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-700">{{ $product->stock_quantity }}
                                            available</span>
                                        <span class="text-xs text-gray-500">Max 10 per order</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <form id="add-to-cart-form" action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" id="form-quantity" value="1">
                                    <button type="submit"
                                        class="w-full bg-primary-600 to-primary-700 text-white py-4 px-6 rounded-xl font-bold text-lg hover:from-primary-700 hover:to-primary-800 transition-all transform hover:scale-105 flex items-center justify-center space-x-3 shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>Add to Cart</span>
                                    </button>
                                </form>

                                <div class="grid grid-cols-2 gap-3">
                                    <button
                                        class="flex items-center justify-center space-x-2 py-3 px-4 border-2 border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <span class="text-sm font-medium">Wishlist</span>
                                    </button>
                                    <button
                                        class="flex items-center justify-center space-x-2 py-3 px-4 border-2 border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                        </svg>
                                        <span class="text-sm font-medium">Share</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Fallback Purchase Section for Testing -->
                        <div class="bg-white border-2 border-gray-200 rounded-2xl p-6 space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Purchase Options (Testing Mode)
                            </h3>

                            <!-- Quantity Selector -->
                            <div class="space-y-3">
                                <label class="text-sm font-medium text-gray-700 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    Quantity
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="flex items-center border-2 border-gray-300 rounded-xl overflow-hidden bg-white shadow-sm">
                                        <button type="button" data-action="decrement" data-fallback="true"
                                            class="px-4 py-3 text-gray-600 hover:bg-gray-100 transition-all font-semibold hover:text-primary-600 active:bg-gray-200"
                                            title="Decrease quantity">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input type="number" id="quantity-fallback" value="1" min="1"
                                            max="10"
                                            class="w-20 text-center border-0 focus:ring-0 py-3 font-bold text-lg text-gray-800 bg-gray-50"
                                            readonly>
                                        <button type="button" data-action="increment" data-fallback="true"
                                            class="px-4 py-3 text-gray-600 hover:bg-gray-100 transition-all font-semibold hover:text-primary-600 active:bg-gray-200"
                                            title="Increase quantity">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-red-700">Out of Stock</span>
                                        <span class="text-xs text-gray-500">Testing Mode</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <form id="add-to-cart-form-fallback" action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" id="form-quantity-fallback" value="1">
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-gray-400 to-gray-500 text-white py-4 px-6 rounded-xl font-bold text-lg hover:from-gray-500 hover:to-gray-600 transition-all flex items-center justify-center space-x-3 shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>Add to Cart (Testing)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Features -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 border-t border-gray-200">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                            <div>
                                <div class="font-medium text-secondary-800">Free Shipping</div>
                                <div class="text-sm text-gray-600">On orders over ₦50,000</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <div>
                                <div class="font-medium text-secondary-800">Secure Payment</div>
                                <div class="text-sm text-gray-600">100% secure checkout</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <div>
                                <div class="font-medium text-secondary-800">Quality Guarantee</div>
                                <div class="text-sm text-gray-600">Verified products</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="mt-16">
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8">
                        <button data-tab="description"
                            class="py-4 px-1 border-b-2 font-medium text-sm capitalize transition-colors border-primary-500 text-primary-600">
                            Description
                        </button>
                        <button data-tab="specifications"
                            class="py-4 px-1 border-b-2 font-medium text-sm capitalize transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Specifications
                        </button>
                        <button data-tab="reviews"
                            class="py-4 px-1 border-b-2 font-medium text-sm capitalize transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Reviews ({{ $product->reviews_count ?? 0 }})
                        </button>
                    </nav>
                </div>

                <div class="py-8">
                    <!-- Description Tab -->
                    <div data-tab-content="description" class="prose max-w-none">
                        {!! $product->description ?:
                            '<p class="text-gray-700 leading-relaxed">No description available for this product.</p>' !!}
                    </div>

                    <!-- Specifications Tab -->
                    <div data-tab-content="specifications" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-secondary-800 mb-4">Product Details</h3>
                                <dl class="space-y-3">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">SKU:</dt>
                                        <dd class="font-medium">{{ $product->sku ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Category:</dt>
                                        <dd class="font-medium">{{ $product->category->name }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Vendor:</dt>
                                        <dd class="font-medium">
                                            {{ $product->vendor->store_name ?? $product->vendor->name }}</dd>
                                    </div>
                                    @if ($product->weight)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-600">Weight:</dt>
                                            <dd class="font-medium">{{ $product->weight }} kg</dd>
                                        </div>
                                    @endif
                                    @if ($product->dimensions)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-600">Dimensions:</dt>
                                            <dd class="font-medium">{{ $product->dimensions }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                            @if ($product->attributes?->count() > 0)
                                <div>
                                    <h3 class="font-semibold text-secondary-800 mb-4">Specifications</h3>
                                    <dl class="space-y-3">
                                        @foreach ($product->attributes as $attribute)
                                            <div class="flex justify-between">
                                                <dt class="text-gray-600">{{ $attribute->name }}:</dt>
                                                <dd class="font-medium">{{ $attribute->pivot->value }}</dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div data-tab-content="reviews" class="hidden">
                        @if ($product->reviews->count() > 0)
                            <div class="space-y-6">
                                @foreach ($product->reviews as $review)
                                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                        <div class="flex items-start justify-between mb-4">
                                            <div>
                                                <h4 class="font-semibold text-secondary-800">{{ $review->user->name }}
                                                </h4>
                                                <div class="flex items-center mt-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <svg class="h-5 w-5 text-yellow-400 fill-current"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @else
                                                            <svg class="h-5 w-5 text-gray-300"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="text-sm text-gray-500">
                                                {{ $review->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                                @auth
                                    <a href="#"
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Write a Review
                                    </a>
                                @else
                                    <p class="mt-2 text-sm text-gray-600">
                                        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700">Sign
                                            in</a> to write a review
                                    </p>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-secondary-800 mb-8">Related Products</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <a href="{{ route('products.show', $relatedProduct->slug) }}"
                                class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                                <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
                                    @if ($relatedProduct->imagesFirst && count($relatedProduct->imagesFirst) > 0)
                                        <img src="{{ asset('storage/' . $relatedProduct->imagesFirst[0]['path']) }}"
                                            alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-secondary-800 mb-2 line-clamp-2">
                                        {{ $relatedProduct->name }}
                                    </h3>
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-primary-600">
                                            ₦{{ number_format($relatedProduct->sale_price ?? $relatedProduct->price, 0) }}
                                        </span>
                                        @if ($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                                            <span class="text-sm text-gray-500 line-through">
                                                ₦{{ number_format($relatedProduct->price, 0) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxQuantity = {{ $product->stock_quantity ?? 10 }};

            // Handle both normal and fallback quantity controls
            function setupQuantityControls(quantitySelector, minusSelector, plusSelector, formQuantitySelector) {
                const quantityInput = document.querySelector(quantitySelector);
                const minusBtn = document.querySelector(minusSelector);
                const plusBtn = document.querySelector(plusSelector);

                if (!quantityInput || !minusBtn || !plusBtn) return;

                function updateQuantity(newQuantity) {
                    if (newQuantity >= 1 && newQuantity <= Math.min(10, maxQuantity)) {
                        quantityInput.value = newQuantity;

                        // Update hidden form input
                        const formQuantityInput = document.querySelector(formQuantitySelector);
                        if (formQuantityInput) {
                            formQuantityInput.value = newQuantity;
                        }

                        // Update button states with visual feedback
                        minusBtn.disabled = newQuantity <= 1;
                        plusBtn.disabled = newQuantity >= Math.min(10, maxQuantity);

                        // Add visual feedback for disabled buttons
                        if (newQuantity <= 1) {
                            minusBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            minusBtn.classList.remove('hover:bg-gray-100');
                        } else {
                            minusBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            minusBtn.classList.add('hover:bg-gray-100');
                        }

                        if (newQuantity >= Math.min(10, maxQuantity)) {
                            plusBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            plusBtn.classList.remove('hover:bg-gray-100');
                        } else {
                            plusBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            plusBtn.classList.add('hover:bg-gray-100');
                        }
                    }
                }

                // Initialize button states
                updateQuantity(1);

                minusBtn.addEventListener('click', () => {
                    updateQuantity(parseInt(quantityInput.value) - 1);
                });

                plusBtn.addEventListener('click', () => {
                    updateQuantity(parseInt(quantityInput.value) + 1);
                });

                quantityInput.addEventListener('change', (e) => {
                    let value = parseInt(e.target.value) || 1;
                    value = Math.max(1, Math.min(Math.min(10, maxQuantity), value));
                    updateQuantity(value);
                });

                // Prevent form submission on Enter key in quantity input
                quantityInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                    }
                });
            }

            // Setup normal quantity controls
            setupQuantityControls('#quantity', '[data-action="decrement"]:not([data-fallback])',
                '[data-action="increment"]:not([data-fallback])', '#form-quantity');

            // Setup fallback quantity controls
            setupQuantityControls('#quantity-fallback', '[data-action="decrement"][data-fallback]',
                '[data-action="increment"][data-fallback]', '#form-quantity-fallback');

            // Add to cart form submission - handle both normal and fallback forms
            const addToCartForms = document.querySelectorAll('#add-to-cart-form, #add-to-cart-form-fallback');
            addToCartForms.forEach(function(addToCartForm) {
                addToCartForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Adding...
                `;

                    // Get quantity from the form's hidden input
                    const formQuantityInput = this.querySelector('input[name="quantity"]');
                    const quantity = formQuantityInput ? parseInt(formQuantityInput.value) : 1;

                    // Submit the form via AJAX
                    fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                product_id: {{ $product->id }},
                                quantity: quantity
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Update cart count in the header
                                const cartCount = document.querySelector('.cart-count');
                                if (cartCount && data.cart_count) {
                                    cartCount.textContent = data.cart_count;
                                }

                                // Show success toast
                                showToast('✅ Product added to cart successfully!', 'success');
                            } else {
                                showToast(data.message || 'Failed to add product to cart.',
                                    'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('❌ An error occurred while adding the product to cart.',
                                'error');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            });

            // Wishlist functionality
            const wishlistBtn = document.getElementById('wishlist-btn');
            if (wishlistBtn) {
                wishlistBtn.addEventListener('click', function() {
                    const icon = this.querySelector('svg');
                    const isInWishlist = icon.classList.contains('text-red-500');
                    const url = isInWishlist ? '{{ route('wishlist.remove') }}' :
                        '{{ route('wishlist.add') }}';
                    const method = isInWishlist ? 'DELETE' : 'POST';

                    fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                product_id: {{ $product->id }}
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                icon.classList.toggle('text-red-500');
                                icon.classList.toggle('fill-current');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('An error occurred while updating your wishlist.', 'error');
                        });
                });
            }

            // Tab functionality
            const tabButtons = document.querySelectorAll('[data-tab]');
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.getAttribute('data-tab');

                    // Update active tab button
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-primary-500', 'text-primary-600');
                        btn.classList.add('border-transparent', 'text-gray-500',
                            'hover:text-gray-700', 'hover:border-gray-300');
                    });
                    button.classList.remove('border-transparent', 'text-gray-500',
                        'hover:text-gray-700', 'hover:border-gray-300');
                    button.classList.add('border-primary-500', 'text-primary-600');

                    // Show active tab content
                    document.querySelectorAll('[data-tab-content]').forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.querySelector(`[data-tab-content="${tabId}"]`).classList.remove(
                        'hidden');
                });
            });
        });

        // Function to change main image
        function changeMainImage(imageSrc, imageIndex) {
            const mainImage = document.getElementById('main-image');
            if (mainImage) {
                // Add loading effect
                mainImage.style.opacity = '0.5';
                mainImage.src = imageSrc;

                // Restore opacity when image loads
                mainImage.onload = function() {
                    mainImage.style.opacity = '1';
                };
            }

            // Update image counter
            const imageCounter = document.querySelector('.absolute.top-4.right-4');
            if (imageCounter && imageIndex) {
                const totalImages = document.querySelectorAll('.thumbnail-btn').length;
                imageCounter.textContent = `${imageIndex} / ${totalImages}`;
            }

            // Update active thumbnail
            document.querySelectorAll('.thumbnail-btn').forEach((btn, index) => {
                if (index === imageIndex - 1) {
                    btn.classList.remove('border-gray-200', 'hover:border-primary-300');
                    btn.classList.add('border-primary-500', 'ring-2', 'ring-primary-200');
                } else {
                    btn.classList.remove('border-primary-500', 'ring-2', 'ring-primary-200');
                    btn.classList.add('border-gray-200', 'hover:border-primary-300');
                }
            });
        }
        }

        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-down flex items-center ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;

            toast.innerHTML = `
            <span class="mr-2">${type === 'success' ? '✅' : '❌'}</span>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;

            document.body.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.classList.add('animate-fade-out');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }
    </script>
@endsection

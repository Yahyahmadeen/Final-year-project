@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-secondary-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500 mr-3" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        My Wishlist
                    </h1>
                    <p class="text-gray-600 mt-2">
                        {{ $wishlistItems->count() }} items saved for later
                    </p>
                </div>
                <a 
                    href="{{ route('shop') }}" 
                    class="bg-primary-500 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-primary-600 transition-colors inline-flex items-center justify-center"
                >
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($wishlistItems->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlistItems as $item)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <div class="relative">
                            <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                                @php
                                    $images = is_array($item->product->images) ? $item->product->images : json_decode($item->product->images, true);
                                    $firstImage = is_array($images) ? ($images[0] ?? null) : null;
                                @endphp
                                @if(!empty($firstImage) && is_array($firstImage) && isset($firstImage['path']))
                                    <img 
                                        src="{{ Storage::url($firstImage['path']) }}" 
                                        alt="{{ $item->product->name }}" 
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                    >
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute top-4 right-4 flex space-x-2">
                                <form action="{{ route('wishlist.remove', $item->product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-white p-2 rounded-full shadow-lg hover:bg-gray-50 text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @if($item->product->sale_price && $item->product->sale_price < $item->product->price)
                                <div class="absolute top-4 left-4 bg-red-500 text-white px-2 py-1 rounded-lg text-sm font-semibold">
                                    {{ round((($item->product->price - $item->product->sale_price) / $item->product->price) * 100) }}% OFF
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="text-sm text-primary-600 mb-1">{{ $item->product->vendor->store_name ?? 'eProShop' }}</div>
                            <a href="{{ route('products.show', $item->product->slug) }}" class="block">
                                <h3 class="text-lg font-semibold text-secondary-800 mb-2 line-clamp-2 hover:text-primary-600">
                                    {{ $item->product->name }}
                                </h3>
                            </a>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xl font-bold text-secondary-800">
                                        {{ number_format($item->product->sale_price ?? $item->product->price, 2) }} MAD
                                    </span>
                                    @if($item->product->sale_price && $item->product->sale_price < $item->product->price)
                                        <span class="text-sm text-gray-500 line-through">
                                            {{ number_format($item->product->price, 2) }} MAD
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-primary-500 text-white py-2 rounded-xl hover:bg-primary-600 transition-colors flex items-center justify-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 0h10m0 0a2 2 0 100 4 2 2 0 000-4z" />
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="bg-gray-100 w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-600 mb-4">Your wishlist is empty</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Save items you love by clicking the heart icon on any product. 
                    They'll appear here for easy access later.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a 
                        href="{{ route('shop') }}" 
                        class="bg-primary-500 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-primary-600 transition-colors"
                    >
                        Discover Products
                    </a>
                    <a 
                        href="{{ route('categories.index') }}" 
                        class="border-2 border-primary-500 text-primary-500 px-8 py-4 rounded-2xl font-semibold hover:bg-primary-500 hover:text-white transition-colors"
                    >
                        Browse Categories
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Recommendations Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-secondary-800 mb-4">You Might Also Like</h2>
                <p class="text-gray-600">Discover more products from our featured collection</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                @foreach($featuredProducts as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
            
            <div class="text-center">
                <a 
                    href="{{ route('shop', ['featured' => 1]) }}" 
                    class="bg-primary-500 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-primary-600 transition-colors inline-block"
                >
                    View All Featured Products
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any necessary JavaScript here
    document.addEventListener('DOMContentLoaded', function() {
        // Handle remove from wishlist
        document.querySelectorAll('.remove-from-wishlist').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

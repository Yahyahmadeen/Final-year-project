@extends('layouts.app')

@push('styles')
    <style>
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .product-image {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9fafb;
            position: relative;
            overflow: hidden;
        }
        .product-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .product-card:hover .product-actions {
            opacity: 1;
        }
        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #ef4444;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }
        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            margin: 0 0.25rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .pagination .page-item.disabled .page-link {
            color: #9ca3af;
            background-color: #f3f4f6;
            border-color: #e5e7eb;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle filters
            const filtersToggle = document.getElementById('filters-toggle');
            const filtersContainer = document.getElementById('filters-container');
            
            if (filtersToggle && filtersContainer) {
                filtersToggle.addEventListener('click', function() {
                    filtersContainer.classList.toggle('hidden');
                });
            }

            // Handle quantity selectors
            document.querySelectorAll('.quantity-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    const action = this.dataset.action;
                    const quantityInput = document.querySelector(`#quantity-${productId}`);
                    
                    if (quantityInput) {
                        let quantity = parseInt(quantityInput.value);
                        
                        if (action === 'decrease' && quantity > 1) {
                            quantity--;
                        } else if (action === 'increase' && quantity < 10) {
                            quantity++;
                        }
                        
                        quantityInput.value = quantity;
                        
                        // Update the add to cart button text
                        const addButton = document.querySelector(`#add-to-cart-${productId} .quantity-text`);
                        if (addButton) {
                            addButton.textContent = quantity;
                        }
                    }
                });
            });

            // Toggle quantity selector
            document.querySelectorAll('.toggle-quantity').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    const selector = document.getElementById(`quantity-selector-${productId}`);
                    const addButton = document.getElementById(`add-to-cart-${productId}`);
                    
                    if (selector && addButton) {
                        const isHidden = selector.classList.contains('hidden');
                        
                        if (isHidden) {
                            // Show quantity selector
                            selector.classList.remove('hidden');
                            addButton.classList.add('hidden');
                        } else {
                            // Hide quantity selector
                            selector.classList.add('hidden');
                            addButton.classList.remove('hidden');
                        }
                    }
                });
            });

            // Handle filter changes
            document.querySelectorAll('.filter-select').forEach(select => {
                select.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        });

        // Add to cart function
        function addToCart(productId) {
            const quantity = document.querySelector(`#quantity-${productId}`).value;
            
            // Show loading state
            const addButton = document.querySelector(`#add-to-cart-${productId}`);
            const originalHtml = addButton.innerHTML;
            addButton.disabled = true;
            addButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Adding...
            `;
            
            // Submit the form via AJAX
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                // Update cart count in the header
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }
                
                // Show success message
                const message = document.createElement('div');
                message.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                message.textContent = 'Product added to cart!';
                document.body.appendChild(message);
                
                // Remove message after 3 seconds
                setTimeout(() => {
                    message.remove();
                }, 3000);
                
                // Reset quantity selector
                const selector = document.getElementById(`quantity-selector-${productId}`);
                const addButtonContainer = document.getElementById(`add-to-cart-${productId}`);
                if (selector && addButtonContainer) {
                    selector.classList.add('hidden');
                    addButtonContainer.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the product to cart.');
            })
            .finally(() => {
                addButton.disabled = false;
                addButton.innerHTML = originalHtml;
            });
        }
    </script>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Shop</h1>
                    <p class="text-gray-600 mt-1">
                        {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
                    </p>
                </div>
                
                <!-- Search and Filters -->
                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                    <form action="{{ route('shop') }}" method="GET" class="flex">
                        <input
                            type="text"
                            name="search"
                            placeholder="Search products..."
                            value="{{ request('search') }}"
                            class="px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent w-full sm:w-64"
                        />
                        <button
                            type="submit"
                            class="bg-primary-500 text-white px-4 py-2 rounded-r-lg hover:bg-primary-600 transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                    
                    <button
                        id="filters-toggle"
                        class="flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span class="hidden sm:inline">Filters</span>
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div id="filters-container" class="mt-6 p-4 bg-gray-50 rounded-lg hidden">
                <form method="GET" action="{{ route('shop') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Hidden fields to maintain other query parameters -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <!-- Categories -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Category
                        </label>
                        <select
                            name="category"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent filter-select"
                            onchange="this.form.submit()"
                        >
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Vendors -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Vendor
                        </label>
                        <select
                            name="vendor"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent filter-select"
                            onchange="this.form.submit()"
                        >
                            <option value="">All Vendors</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->slug }}" {{ request('vendor') == $vendor->slug ? 'selected' : '' }}>
                                    {{ $vendor->store_name }} ({{ $vendor->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sort By
                        </label>
                        <select
                            name="sort"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent filter-select"
                            onchange="this.form.submit()"
                        >
                            <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Best Rated</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
                @foreach($products as $product)
                    <div class="product-card bg-white rounded-xl overflow-hidden border border-gray-100">
                        <div class="relative">
                            <div class="product-image aspect-square flex items-center justify-center bg-gray-100">
                                @php
                                    $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                                    $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                                @endphp
                                
                                @if($firstImage && is_string($firstImage))
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                                
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <div class="discount-badge">
                                        -{{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%
                                    </div>
                                @endif
                                
                                <div class="product-actions">
                                    <button class="bg-white p-1.5 rounded-full shadow-lg hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="text-xs text-primary-600 mb-1 truncate">{{ $product->vendor->store_name ?? 'Vendor' }}</div>
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <h3 class="text-sm font-medium text-gray-900 mb-2 line-clamp-2 hover:text-primary-600 leading-tight">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            <div class="flex items-center mb-2">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->average_rating))
                                            <svg class="h-3 w-3 text-yellow-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="h-3 w-3 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500 ml-1">({{ $product->reviews_count ?? 0 }})</span>
                            </div>
                            
                            <div class="space-y-2">
                                <div class="flex flex-col">
                                    <span class="text-sm sm:text-base font-bold text-gray-900">
                                        {{ number_format($product->sale_price ?? $product->price, 2) }} MAD
                                    </span>
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <span class="text-xs text-gray-500 line-through">
                                            {{ number_format($product->price, 2) }} MAD
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Quantity Selector (Hidden by default) -->
                                <div id="quantity-selector-{{ $product->id }}" class="hidden">
                                    <div class="flex items-center justify-between bg-gray-50 p-1 rounded-lg">
                                        <button 
                                            class="quantity-button w-6 h-6 flex items-center justify-center bg-white border border-gray-300 rounded-full hover:bg-gray-100"
                                            data-product-id="{{ $product->id }}"
                                            data-action="decrease"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        
                                        <input 
                                            type="number" 
                                            id="quantity-{{ $product->id }}" 
                                            value="1" 
                                            min="1" 
                                            max="10" 
                                            class="w-8 text-center text-sm font-medium border-0 bg-transparent focus:ring-0 p-0" 
                                            readonly
                                        >
                                        
                                        <button 
                                            class="quantity-button w-6 h-6 flex items-center justify-center bg-white border border-gray-300 rounded-full hover:bg-gray-100"
                                            data-product-id="{{ $product->id }}"
                                            data-action="increase"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <button 
                                        onclick="addToCart({{ $product->id }})"
                                        class="w-full mt-2 bg-green-500 text-white py-1.5 rounded-lg hover:bg-green-600 transition-colors text-xs font-medium"
                                    >
                                        Add <span class="quantity-text">1</span> to Cart
                                    </button>
                                    
                                    <button
                                        onclick="document.getElementById('quantity-selector-{{ $product->id }}').classList.add('hidden'); document.getElementById('add-to-cart-{{ $product->id }}').classList.remove('hidden');"
                                        class="w-full mt-1 text-center text-xs text-gray-500 hover:text-gray-700"
                                    >
                                        Cancel
                                    </button>
                                </div>
                                
                                <!-- Add to Cart Button (Visible by default) -->
                                <button 
                                    id="add-to-cart-{{ $product->id }}"
                                    class="toggle-quantity w-full bg-primary-500 text-white py-1.5 rounded-lg hover:bg-primary-600 transition-colors text-xs font-medium flex items-center justify-center space-x-1"
                                    data-product-id="{{ $product->id }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                                
                                <a 
                                    href="{{ route('products.show', $product->slug) }}" 
                                    class="block text-center text-xs text-gray-600 hover:text-primary-600 mt-1"
                                >
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-8">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No products found</h3>
                <p class="text-gray-500">Try adjusting your search or filters</p>
                <a 
                    href="{{ route('shop') }}" 
                    class="mt-4 inline-block px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors text-sm font-medium"
                >
                    Clear Filters
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

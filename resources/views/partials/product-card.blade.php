<div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="aspect-square bg-gray-100 relative overflow-hidden">
            @php
                $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                $firstImage = is_array($images) ? ($images[0] ?? null) : null;
            @endphp
            @if(!empty($firstImage) && is_array($firstImage) && isset($firstImage['path']))
                <img 
                    src="{{ Storage::url($firstImage['path']) }}" 
                    alt="{{ $product->name }}" 
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                    loading="lazy"
                >
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
            
            <!-- Add to Cart Button -->
            <form action="{{ route('cart.add') }}" method="POST" class="absolute bottom-0 left-0 right-0 p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full bg-primary-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-primary-600 transition-colors">
                    Add to Cart
                </button>
            </form>
        </div>
        
        <div class="p-4">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-medium text-gray-900 mb-1 line-clamp-2" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h3>
                    <p class="text-sm text-gray-500">{{ $product->vendor->store_name ?? 'N/A' }}</p>
                </div>
                <div class="text-right">
                    @if($product->sale_price && $product->sale_price < $product->price)
                        <span class="text-lg font-bold text-gray-900">{{ number_format($product->sale_price, 2) }} MAD</span>
                        <span class="text-sm text-gray-500 line-through ml-1">{{ number_format($product->price, 2) }} MAD</span>
                    @else
                        <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 2) }} MAD</span>
                    @endif
                </div>
            </div>
            
            <div class="mt-3 flex items-center justify-between">
                @if($product->average_rating > 0)
                    <div class="flex items-center">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $product->average_rating)
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                            @endfor
                            <span class="text-xs text-gray-500 ml-1">({{ $product->review_count ?? 0 }})</span>
                        </div>
                    </div>
                @else
                    <div class="text-xs text-gray-400">No reviews yet</div>
                @endif
                
                <form action="{{ route('wishlist.add', $product) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </a>
</div>

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated user's wishlist items with product details
        $wishlistItems = auth()->check() 
            ? auth()->user()->wishlist()->with(['product' => function($query) {
                $query->with('vendor');
            }])->get() 
            : collect();

        // Get featured products for the recommendations section
        $featuredProducts = Product::query()
            ->where('is_featured', true)
            ->where('status', 'published')
            ->with('vendor')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('wishlist.index', [
            'wishlistItems' => $wishlistItems,
            'featuredProducts' => $featuredProducts,
        ]);
    }

    /**
     * Add a product to the user's wishlist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to your wishlist.',
                'requires_login' => true
            ], 401);
        }

        $productId = $request->input('product_id');
        $userId = auth()->id();

        // Check if the product is already in the wishlist
        $existingWishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingWishlistItem) {
            return response()->json([
                'success' => false,
                'message' => 'This product is already in your wishlist.'
            ]);
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        // Get the updated wishlist count
        $wishlistCount = auth()->user()->wishlist()->count();

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!',
            'wishlist_count' => $wishlistCount
        ]);
    }

    /**
     * Remove a product from the user's wishlist.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function remove(Product $product)
    {
        if (!auth()->check()) {
            return back()->with('error', 'Please login to manage your wishlist.');
        }

        $wishlistItem = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from wishlist.',
                    'wishlist_count' => auth()->user()->wishlist()->count()
                ]);
            }
            
            return back()->with('success', 'Product removed from wishlist.');
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in your wishlist.'
            ], 404);
        }
        
        return back()->with('error', 'Product not found in your wishlist.');
    }

    /**
     * Toggle a product in the user's wishlist.
     * Adds if not present, removes if already in wishlist.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Product $product)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to manage your wishlist.',
                'requires_login' => true
            ], 401);
        }

        $wishlistItem = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        $added = false;
        
        if ($wishlistItem) {
            $wishlistItem->delete();
            $message = 'Product removed from wishlist.';
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);
            $added = true;
            $message = 'Product added to wishlist!';
        }

        $wishlistCount = auth()->user()->wishlist()->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'added' => $added,
            'wishlist_count' => $wishlistCount
        ]);
    }

    /**
     * Get the count of items in the user's wishlist.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function count()
    {
        $count = auth()->check() ? auth()->user()->wishlist()->count() : 0;
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}

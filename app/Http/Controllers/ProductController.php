<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    public function show(Product $product)
    {
        // Increment view count
        $product->increment('view_count');

        // Load relationships with fallback for images
        $product->load([
            'vendor.user', 
            'category', 
            'reviews.user', 
            'images' => function($query) {
                $query->orderBy('created_at');
            }
        ]);
        
        // Ensure images is always a collection, even if empty
        if (!isset($product->images)) {
            $product->setRelation('images', collect([]));
        }

        // Get related products from same category
        $relatedProducts = Product::with(['vendor', 'category', 'imagesFirst', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        // Get reviews with pagination
        $reviews = ProductReview::with('user')
            ->where('product_id', $product->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate rating distribution
        $ratingDistribution = ProductReview::where('product_id', $product->id)
            ->where('is_approved', true)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Fill missing ratings with 0
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }
        ksort($ratingDistribution);

        // return [
        //     'product' => $product,
        //     'relatedProducts' => $relatedProducts,
        //     'reviews' => $reviews,
        //     'ratingDistribution' => $ratingDistribution,
        // ];

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'ratingDistribution' => $ratingDistribution,
            'inWishlist'=> true,
        ]);
    }

    public function addReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if user already reviewed this product
        $existingReview = ProductReview::where('product_id', $product->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return back()->withErrors(['review' => 'You have already reviewed this product.']);
        }

        // Create review
        ProductReview::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update product average rating
        $this->updateProductRating($product);

        return back()->with('success', 'Review added successfully!');
    }

    private function updateProductRating(Product $product)
    {
        $reviews = ProductReview::where('product_id', $product->id)
            ->where('is_approved', true);

        $averageRating = $reviews->avg('rating') ?: 0;
        $reviewCount = $reviews->count();

        $product->update([
            'average_rating' => round($averageRating, 2),
            'review_count' => $reviewCount,
        ]);
    }
}

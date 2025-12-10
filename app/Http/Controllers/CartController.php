<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with(['product.vendor', 'product.category'])
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->getCurrentPrice() * $item->quantity;
        });

        $tax = $subtotal * 0.075; // 7.5% VAT
        $shipping = $subtotal > 50000 ? 0 : 2500; // Free shipping over ₦50,000
        $total = $subtotal + $tax + $shipping;

        return view('cart.index', [
            'cartItems' => $cartItems,
            'summary' => [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'itemCount' => $cartItems->sum('quantity'),
            ],
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
            'options' => 'nullable|array',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is available
        if (!$product->isInStock()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock.'
                ], 400);
            }
            return back()->withErrors(['cart' => 'Product is out of stock.']);
        }

        // Check if item already exists in cart
        $existingItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $request->quantity;
            
            // Check stock availability
            if ($product->manage_stock && $newQuantity > $product->stock_quantity) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available.'
                    ], 400);
                }
                return back()->withErrors(['cart' => 'Not enough stock available.']);
            }

            $existingItem->update([
                'quantity' => $newQuantity,
                'options' => $request->options,
            ]);
        } else {
            // Check stock availability for new item
            if ($product->manage_stock && $request->quantity > $product->stock_quantity) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available.'
                    ], 400);
                }
                return back()->withErrors(['cart' => 'Not enough stock available.']);
            }

            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'options' => $request->options,
            ]);
        }

        // Get updated cart count
        $cartCount = CartItem::where('user_id', auth()->id())->sum('quantity');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => $cartCount
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, CartItem $item)
    {
        // Ensure user owns the cart item
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        // Check stock availability
        if ($item->product->manage_stock && $request->quantity > $item->product->stock_quantity) {
            return back()->withErrors(['cart' => 'Not enough stock available.']);
        }

        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated!');
    }

    public function destroy(CartItem $item)
    {
        // Ensure user owns the cart item
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    public function getCartCount()
    {
        $count = CartItem::where('user_id', auth()->id())->sum('quantity');
        
        return response()->json(['count' => $count]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class VendorProductController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;

        $products = $vendor->products()->with('images')->latest()->paginate(10);

        $stats = [
            'total' => $vendor->products()->count(),
            'published' => $vendor->products()->where('status', 'published')->count(),
            'draft' => $vendor->products()->where('status', 'draft')->count(),
            'out_of_stock' => $vendor->products()->where('stock_quantity', 0)->count(),
        ];

        return view('vendors.products.index', compact('products', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('vendors.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max per file
        ]);

        // Generate slug and SKU
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']) . '-' . time();
        $validated['sku'] = 'PRD-' . strtoupper(substr(uniqid(), -8));
        $validated['status'] = 'published'; // Default status
        $validated['stock_status'] = $validated['stock_quantity'] > 0 ? 'in_stock' : 'out_of_stock';

        // Create the product
        $product = auth()->user()->vendor->products()->create($validated);

        // Handle file uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'is_primary' => $product->images()->count() === 0 // First image is primary
                ]);
            }
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully with ' . ($request->hasFile('images') ? count($request->file('images')) : 0) . ' image(s)!');
    }

    public function edit(Product $product)
    {
        $vendor = auth()->user()->vendor;
        
        // Ensure the product belongs to this vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $categories = Category::all();
        return view('vendors.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $vendor = auth()->user()->vendor;
        
        // Ensure the product belongs to this vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:published,draft',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        // Update stock status
        $validated['stock_status'] = $validated['stock_quantity'] > 0 ? 'in_stock' : 'out_of_stock';

        // Update the product
        $product->update($validated);

        // Handle new file uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'is_primary' => $product->images()->count() === 0
                ]);
            }
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $vendor = auth()->user()->vendor;
        
        // Ensure the product belongs to this vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete product images from storage
        foreach ($product->images as $image) {
            \Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        
        // Delete the product
        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully!');
    }

}
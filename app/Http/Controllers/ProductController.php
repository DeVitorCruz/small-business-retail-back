<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $relation = [
            'subCategory',
            'images'
        ];

        $products = Product::with($relation)->get();
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'product_code' => 'required|string|max:191|unique:products,product_code'
        ]);

        $product->create($validated);

        return response()->json(['message' => 'Product updated successfully!', 'product' => $product], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $relation = [
            'subCategory',
            'images'
        ];

        $product = Product::with($relation)->findOrFail($id);

        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'product_code' => 'required|string|max:191|unique:products,product_code'
        ]);

        $product->update($validated);
        return response()->json(['message' => 'Product updated successfully!', 'product' => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        $product->images()->delete();

        return response()->json(['message' => 'Product deleted successfully!'], 200);
    }

    public function addImage(Request $request, $productId)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('products', 'public');

        ProductImage::create([
            'product_id' => $productId,
            'image_path' => $path,
            'alt_text' => $request->input('alt_text', '')
        ]);

        return response()->json(['message' => 'Image added successfully!'], 201);
    }

    public function getProductWithImages($productId)
    {
        $product = Product::with('image')->findOrFail($productId);

        return response()->json($product);
    }
}

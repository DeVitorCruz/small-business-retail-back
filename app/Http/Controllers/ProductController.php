<?php

namespace App\Http\Controllers;


use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariations;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     **/
    public function index()
    {

        $relation = [
            'subCategories',
            'images'
        ];

        $products = Product::with($relation)->get();

        return response()->json($products, 200);
    }

    public function indexWithVariations()
    {
        $relation = [
            'subCategories.variations',
            'images',
            'productVariations.variationsTypes',
            'productVariations.variationsValue',
            'productReviews'
        ];

        $products = Product::with($relation)->get();

        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product, Inventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'product_code' => 'required|string|max:191|unique:products,product_code',
            'images' => 'nullable|array',
            'images.*.image_path' => 'required|string|max:191',
            'images.*.alt_text' => 'nullable|string|max:191',
            'variations' => 'nullable|array',
            'variations.*.variation_type_id' => 'required|numeric|exists:variation_types,id',
            'variations.*.variation_id' => 'required|numeric|exists:variations,id',
        ]);

        $createdProduct = $product->create($request->only(['name', 'sub_category_id', 'description', 'product_code']));

        $inventory->create([
            'product_id' => $createdProduct->id,
            'price' => $validated['price'],
            'quantity' => $validated['quantity']
        ]);

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $createdProduct->images()->create($image);
            }
        }

        if ($request->has('variations')) {
            foreach ($request->variations as $variation) {
                $createdProduct->productVariations()->create($variation);
            }
        }

        return response()->json(['message' => 'Product and inventory added successfully!', 'product' => $product], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $relation = [
            'subCategories.variations',
            'images',
            'productReviews'
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

<?php

namespace App\Http\Controllers;

use App\Models\SubCategories;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    public function index()
    {
        $subCategories = SubCategories::with('category')->get();

        return response()->json($subCategories, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $subCategory = SubCategories::create($validated);

        return response()->json(['message' => 'SubCategory created successfully!', 'subCategory' => $subCategory], 201);
    }

    public function show($id)
    {
        $subCategory = SubCategories::with('category')->findOrFail($id);

        return response()->json($subCategory, 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id'
        ]);

        $subCategory = SubCategories::findOrFail($id);
        $subCategory->update($validated);

        return response()->json(['message' => 'SubCategory updated successfully!', 'subCategory' => $subCategory], 200);
    }


    public function destroy($id)
    {
        $subCategory = SubCategories::findOrFail($id);
        $subCategory->delete();

        return response()->json(['message' => 'subCategory deleted successfully!'], 200);
    }
}

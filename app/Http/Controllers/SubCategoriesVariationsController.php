<?php

namespace App\Http\Controllers;

use App\Models\SubCategories;
use App\Models\VariationTypes;
use App\Models\SubCategoriesVariations;
use Illuminate\Http\Request;

class SubCategoriesVariationsController extends Controller
{
    public function index()
    {

        $relations = [
            'categories',
            'variationsTypes'
        ];

        $subCategoriesVariationsType = SubCategories::with($relations)->get();

        $variationTypes = VariationTypes::all();

        $response = [
            'subCategoriesVariationTypes' => $subCategoriesVariationsType,
            'variationTypes' => $variationTypes
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'variation_type_ids' => 'required|array',
            'variation_type_ids.*' => 'exists:variation_types,id'
        ]);

        if (isset($validated['name'])) {

            $variationType = VariationTypes::create(['name' => $validated['name']]);

            $validated['variation_type_ids'][] = $variationType->id;
        }
        
        $subCategory = SubCategories::findOrFail($validated['sub_category_id']);

        $subCategory->variationsTypes()->sync($validated['variation_type_ids']);

        return response()->json($subCategory->load('variationsTypes'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'sub_category_id' => 'required|exists:sub_categories_variations,id',
            'variation_type_ids' => 'array'
        ]);

        SubCategoriesVariations::where('sub_category_id', $validated['sub_category_id'])->delete();

        foreach ($validated['variation_type_ids'] as $typeId) {
            SubCategoriesVariations::create([
                'sub_category_id' => $validated['sub_category_id'],
                'variation_type_id' => $typeId
            ]);
        }

        return response()->json(['message' => 'Variation types updated successfully.']);
    }

    public function destroy($subCategoryId)
    {
        SubCategoriesVariations::where('sub_category_id', $subCategoryId)->delete();

        return response()->json(['message' => 'Variation types deleted successfully.']);
    }
}

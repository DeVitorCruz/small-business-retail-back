<?php

namespace App\Http\Controllers;

use App\Models\Variations;
use App\Models\SubCategories;

use Illuminate\Http\Request;

class VariationController extends Controller
{
    public function getSubCategoryVariations(int $id)
    {

        $relations = [
            'variationsTypes.variations' => function ($query) use ($id) {
                $query->where('sub_category_id', $id);
            }
        ];

        $variations = SubCategories::with($relations)->findOrFail($id);

        return response()->json($variations, 200);
    }

    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'variation_type_id' => 'required|exists:variation_types,id',
            'values' => 'required|array|min:1',
            'values.*' => 'string|max:255'
        ]);

        foreach ($validated['values'] as $value) {
            Variations::create([
                'sub_category_id' => $validated['sub_category_id'],
                'variation_type_id' => $validated['variation_type_id'],
                'value' => $value,
            ]);
        }

        $data = [
            'message' => 'Variations added successfully'
        ];

        return response()->json($data);
    }

    public function update(Request $request, int $id)
    {

        $validated = $request->validate([
            'value' => 'required|string|max:255'
        ]);

        $variation = Variations::findOrFail($id);

        if ($variation->sub_category_id != $request->input('sub_category_id')) {
            return response()->json(['error' => 'SubCategory mismatch'], 400);
        }

        $variation->update(['value' => $validated['value']]);

        return response()->json(['message' => 'Variation updated successfully.']);
    }

    public function destroy(int $id)
    {
        $variation = Variations::findOrFail($id);

        $variation->delete();

        return response()->json(['message' => 'Variation deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\VariationTypes;
use Illuminate\Http\Request;

class VariationTypesController extends Controller
{
    public function index()
    {
        $variationTypes = VariationTypes::all();

        return response()->json($variationTypes, 200);
    }

    public function store(Request $request, VariationTypes $variationType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $variationType->create($validated);

        return response()->json(['message' => 'Variation was successfully created', 'Variation Type' => $variationType], 200);
    }

    public function show($id)
    {
        $variationType = VariationTypes::findOrFail($id);

        return response()->json($variationType, 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $variationType = VariationTypes::findOrFail($id);

        $variationType->update($validated);

        return response()->json(['message' => 'The variation type was updated', 'Variation Type' => $variationType], 200);
    }

    public function destroy($id)
    {
        $variationType = VariationTypes::findOrFail($id);

        $variationType->delete();

        return response()->json(['message' => 'The variation was deleted successfully'], 200);
    }
}

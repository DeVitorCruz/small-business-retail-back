<?php

namespace App\Http\Controllers;
use App\Models\Reviews;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'stars' => 'required|integer|min:0|max:5',
            'comment' => 'nullable|string'
        ]);

        $review = Reviews::create($validated);

        return response()->json(['message'=> 'Review created successfully', 'review' => $review ], 201);

    }
}

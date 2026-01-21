<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'price', 
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

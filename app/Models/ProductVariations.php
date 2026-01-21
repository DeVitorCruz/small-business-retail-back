<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Variations;
use App\Models\VariationTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariations extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variation_type_id',
        'variation_id',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function variations()
    {
        return $this->belongsTo(Variations::class, 'variation_id');
    }

    public function variationsTypes()
    {
        return $this->belongsTo(VariationTypes::class, 'variation_type_id');
    }

    public function variationsValue()
    {
        return $this->belongsTo(Variations::class, 'variation_id');
    }

}

<?php

namespace App\Models;

use App\Models\Categories;
use App\Models\Product;
use App\Models\Variations;
use App\Models\VariationTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SubCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }

    public function variations()
    {
        return $this->hasMany(Variations::class, 'sub_category_id', 'id');
    }
    
    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function variationsTypes()
    {
        return $this->belongsToMany(VariationTypes::class, 'sub_categories_variations', 'sub_category_id', 'variation_type_id', 'id'); 
    }

}

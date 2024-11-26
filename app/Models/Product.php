<?php

namespace App\Models;

use App\Models\ProductImage;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'sub_category_id',
        'product_code'
    ];

    public function subCategory() 
    {
        return $this->belongsTo(Categories::class);
    } 

    public function images() 
    {
        return $this->hasMany(ProductImage::class);
    }

}

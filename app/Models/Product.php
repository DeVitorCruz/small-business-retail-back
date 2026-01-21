<?php

namespace App\Models;

use App\Models\ProductImage;
use App\Models\ProductVariations;
use App\Models\Categories;
use App\Models\SubCategories;
use App\Models\Reviews;
use App\Models\Inventory;
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

    public function categories()
    {
        return $this->hasOneThrough(Categories::class, SubCategories::class);
    }

    public function subCategories()
    {
        return $this->belongsTo(SubCategories::class, 'sub_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function productVariations()
    {
        return $this->hasMany(ProductVariations::class, 'product_id');
    }

    public function productReviews()
    {
        return $this->hasMany(Reviews::class, 'product_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}

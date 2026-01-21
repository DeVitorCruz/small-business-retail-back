<?php

namespace App\Models;

use App\Models\SubCategories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Categories extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCategories::class, 'category_id', 'sub_category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategories::class, 'category_id');
    }
}

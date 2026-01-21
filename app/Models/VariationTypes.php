<?php

namespace App\Models;

use App\Models\SubCategories;
use App\Models\Variations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VariationTypes extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function subCategories()
    {
        return $this->belongsToMany(SubCategories::class, 'sub_categories_variations');
    }

    public function variations()
    {
        return $this->hasMany(Variations::class, 'variation_type_id');
    }
}

<?php

namespace App\Models;

use App\Models\SubCategories;
use App\Models\VariationTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SubCategoriesVariations extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'variation_type_id'
    ];

    public function subCategories()
    {
        return $this->belongsTo(SubCategories::class, 'sub_category_id');
    }

    public function variationTypes()
    {
        return $this->belongsTo(VariationTypes::class, 'variation_type_id');
    }
}

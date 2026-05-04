<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecDimension extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order'];

    public function options()
    {
        return $this->hasMany(SpecOption::class)->orderBy('sort_order');
    }

    public function productTypes()
    {
        return $this->belongsToMany(ProductType::class, 'product_type_spec_dimensions')
            ->withPivot('is_required', 'sort_order');
    }
}

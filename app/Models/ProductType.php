<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = ['name', 'slug', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function specDimensions()
    {
        return $this->belongsToMany(SpecDimension::class, 'product_type_spec_dimensions')
            ->withPivot('is_required', 'sort_order')
            ->orderByPivot('sort_order');
    }

    public function basePrices()
    {
        return $this->hasMany(ProductBasePrice::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

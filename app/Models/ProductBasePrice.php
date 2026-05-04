<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBasePrice extends Model
{
    protected $fillable = ['product_type_id', 'spec_option_ids', 'base_price'];

    protected function casts(): array
    {
        return [
            'spec_option_ids' => 'array',
            'base_price' => 'decimal:2',
        ];
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}

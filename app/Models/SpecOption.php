<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecOption extends Model
{
    protected $fillable = ['spec_dimension_id', 'label', 'price_addon', 'sort_order'];

    protected function casts(): array
    {
        return ['price_addon' => 'decimal:2'];
    }

    public function dimension()
    {
        return $this->belongsTo(SpecDimension::class, 'spec_dimension_id');
    }
}

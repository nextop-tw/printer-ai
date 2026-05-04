<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuantityDiscount extends Model
{
    protected $fillable = ['min_quantity', 'discount_rate'];

    protected function casts(): array
    {
        return ['discount_rate' => 'decimal:2'];
    }

    public static function rateFor(int $quantity): float
    {
        return (float) static::where('min_quantity', '<=', $quantity)
            ->orderByDesc('min_quantity')
            ->value('discount_rate') ?? 1.00;
    }
}

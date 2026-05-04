<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'product_type_id', 'printer_id', 'order_no',
        'spec_snapshot', 'unit_price', 'quantity', 'discount_rate',
        'total_price', 'file_path', 'file_analysis', 'status',
        'estimated_completion_date', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'spec_snapshot' => 'array',
            'file_analysis' => 'array',
            'unit_price' => 'decimal:2',
            'discount_rate' => 'decimal:2',
            'total_price' => 'decimal:2',
            'estimated_completion_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function lineNotifications()
    {
        return $this->hasMany(LineNotification::class);
    }
}

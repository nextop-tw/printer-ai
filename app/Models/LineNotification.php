<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineNotification extends Model
{
    protected $fillable = [
        'order_id', 'printer_id', 'message', 'status', 'sent_at',
    ];

    protected function casts(): array
    {
        return ['sent_at' => 'datetime'];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }
}

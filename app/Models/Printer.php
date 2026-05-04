<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Printer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'contact_name',
        'phone',
        'email',
        'password',
        'line_user_id',
        'working_days',
        'status',
        'admin_suspended',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'admin_suspended' => 'boolean',
        ];
    }

    public function isAvailable(): bool
    {
        return !$this->admin_suspended && $this->status === 'active';
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

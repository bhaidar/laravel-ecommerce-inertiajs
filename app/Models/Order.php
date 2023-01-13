<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    public $timestamps = [
      'placed_at',
      'packaged_at',
      'shipped_at'
    ];

    public $fillable = [
        'email',
        'subtotal',
        'placed_at',
        'packaged_at',
        'shipped_at',
    ];

    protected static function booted()
    {
        static::creating(function (Order $order) {
           $order->placed_at = now();
            $order->uuid = (string)Str::uuid();
        });
    }
}

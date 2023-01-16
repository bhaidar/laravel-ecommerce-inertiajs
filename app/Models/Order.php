<?php

namespace App\Models;

use App\Traits\HasFormattedPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    use HasFormattedPrice;

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

    public $statuses = [
        'placed_at' => 'Order Placed',
        'packaged_at' => 'Order Packaged',
        'shipped_at' => 'Order Shipped',
    ];

    protected function getMoneyAttribute(): string
    {
        return 'subtotal';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function shippingType(): BelongsTo
    {
        return $this->belongsTo(ShippingType::class);
    }

    public function variations(): BelongsToMany
    {
        return $this->belongsToMany(Variation::class)
            ->withPivot(['quantity'])
            ->withTimestamps();
    }

    public function status()
    {
        return collect($this->statuses)
            ->last(fn ($status, $key) => filled($this->{$key}));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Variation extends Model
{
    use HasFactory;

    protected $appends = [
        'display_name',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the formatted title.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::title($this->type),
        );
    }
}

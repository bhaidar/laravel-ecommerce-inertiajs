<?php

namespace App\Models;

use App\Console\Traits\HasFormattedPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use HasFormattedPrice;

    public function variations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Variation::class)->whereNull('parent_id');
    }
}

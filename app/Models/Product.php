<?php

namespace App\Models;

use App\Console\Traits\HasFormattedPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 */
class Product extends Model
{
    use HasFactory;
    use HasFormattedPrice;
}

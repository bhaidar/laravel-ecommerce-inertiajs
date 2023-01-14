<?php

namespace App\Casts;

use Cknow\Money\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyAttribute implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Money
     */
    public function get($model, string $key, $value, array $attributes): Money
    {
        return money($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}

<?php

namespace App\Base;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

abstract class BaseDTO extends Data
{
    public function resolve(mixed $value, mixed $default = null)
    {
        return $value instanceof Optional ? $default : $value;
    }

    public function isFilled(mixed $value): bool
    {
        return !($value instanceof Optional);
    }
}

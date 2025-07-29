<?php

namespace App\Base\Traits;

use Illuminate\Support\Arr;

trait RemembersResults
{
    protected array $cache = [];

    protected function remember(string $key, callable $callback)
    {
        if (!Arr::has($this->cache, $key)) {
            Arr::set($this->cache, $key, $callback());
        }

        return Arr::get($this->cache, $key);
    }
}

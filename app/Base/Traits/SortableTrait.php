<?php

namespace App\Base\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\EloquentSortable\SortableTrait as BaseSortableTrait;

trait SortableTrait
{
    use BaseSortableTrait;

    public function buildSortQuery(): Builder
    {
        $query = static::query();

        foreach ($this->determineSortGroupColumns() as $sortGroupColumn) {
            $query->where($sortGroupColumn, $this->getAttribute($sortGroupColumn));
        }

        return $query;
    }

    public function updatePosition(int $position): void
    {
        $orderColumnName = $this->determineOrderColumnName();

        $currentPosition = $this->getAttribute($orderColumnName);

        if ($currentPosition === $position) {
            return;
        }

        $this->$orderColumnName = $position;
        $this->save();

        $query = $this->buildSortQuery()
            ->whereBetween($orderColumnName, collect([$position, $currentPosition])->sort())
            ->where($this->getKeyName(), '!=', $this->getKey());

        if ($currentPosition > $position) {
            $query->increment($orderColumnName);
        } else {
            $query->decrement($orderColumnName);
        }
    }

    public function determineOrderColumnName(): string
    {
        if (property_exists($this, 'orderColumnName')) {
            return $this->orderColumnName;
        }

        return 'sort';
    }

    public function determineSortGroupColumns(): array
    {
        if (property_exists($this, 'sortGroupColumns')) {
            return Arr::wrap($this->sortGroupColumns);
        }

        return [];
    }

    public static function rearrange(): void
    {
        static::setNewOrder(self::query()->withoutGlobalScopes()->pluck(static::newModelInstance()->getKeyName()));
    }
}

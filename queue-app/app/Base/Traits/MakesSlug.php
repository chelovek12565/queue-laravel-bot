<?php

namespace App\Base\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait MakesSlug
{
    protected function slug(Model $model, $string, array $wheres = [], $slugAttribute = 'slug'): string
    {
        $slug = Str::slug($string);
        $count = 1;

        while ($this->isSlugExists($model, $slug, $slugAttribute, $wheres)) {
            $slug = Str::slug("$string-$count");
            $count++;
        }

        return $slug;
    }

    private function isSlugExists(Model $model, $slug, $slugAttribute, array $wheres = []): bool
    {
        $query = $model->newModelQuery()
            ->where($slugAttribute, $slug)
            ->when($model->exists, fn(Builder $query, $ignoreId) => $query->where($model->getKeyName(), '!=', $model->getKey()));

        foreach ($wheres as $column => $value) {
            $query->where($column, $value);
        }

        return $query->exists();
    }
}

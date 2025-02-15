<?php

namespace App\Base\Repositories;

use App\Domain\Application\Helpers\StringKeymapHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LogicException;

abstract class BaseEloquentRepository
{
    public function __construct()
    {
        if (!is_subclass_of($this->modelClass(), Model::class)) {
            throw new LogicException(sprintf('%s::modelClass must return %s class string', static::class, Model::class));
        }
    }

    abstract protected function modelClass(): string;

    protected function newQuery(): Builder
    {
        return $this->getModelInstance()->newQuery();
    }

    protected function getModelInstance(): Model
    {
        $modelClass = $this->modelClass();

        return new $modelClass;
    }

    protected function qualifyColumn($column): string
    {
        return $this->getModelInstance()->qualifyColumn($column);
    }

    protected function searchInColumnsByWords(Builder $query, string $search, string ...$columns): void
    {
        $words = Str::of($search)->explode(' ');
        $query->where(function (Builder $query) use ($columns, $words) {
            foreach ($columns as $column) {
                $query->orWhere(
                    fn(Builder $query) => $words->each(
                        fn($word) => $query->where(fn(Builder $query) => $query
                            ->where($column, 'like', "%$word%")
                            ->orWhere($column, 'like', "%" . StringKeymapHelper::switchKeymap($word) . "%")
                            ->orWhere($column, 'like', "%" . StringKeymapHelper::translitKeymap($word) . "%")
                        )
                    )
                );
            }
        });
    }
}

<?php

namespace App\Domain\User\Domain\Repositories;

use App\Base\Repositories\BaseEloquentRepository;
use App\Domain\User\Domain\Entities\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder|User newQuery()
 */
class UserRepository extends BaseEloquentRepository
{
    protected function modelClass(): string
    {
        return User::class;
    }

    public function find(int $id):?User
    {
        return $this->newQuery()->find($id);
    }

    public function findByTgid(int $tgid): ?User
    {
        return $this->newQuery()->firstWhere('tgid', $tgid);
    }
}

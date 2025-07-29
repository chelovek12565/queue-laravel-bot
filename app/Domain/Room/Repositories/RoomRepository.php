<?php

namespace App\Domain\Room\Repositories;

use App\Base\Repositories\BaseEloquentRepository;
use App\Domain\Room\Entities\Room;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder|Room newQuery()
 */
class RoomRepository extends BaseEloquentRepository
{
    protected function modelClass(): string
    {
        return Room::class;
    }

    public function find(int $id):?Room
    {
        return $this->newQuery()->find($id);
    }

    public function findByName(string $name): ?Room
    {
        return $this->newQuery()->firstWhere('name', $name);
    }

    public function findByCreator(int $userId): Builder
    {
        return $this->newQuery()->where('user_id', $userId);
    }
}

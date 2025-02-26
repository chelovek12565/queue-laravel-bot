<?php

namespace App\Domain\Queue\Repositories;

use App\Base\Repositories\BaseEloquentRepository;
use App\Domain\Queue\Entities\Queue;

class QueueRepository extends BaseEloquentRepository
{
    protected function modelClass(): string
    {
        return Queue::class;
    }

    public function find(int $id): ?Queue
    {
        return $this->newQuery()->find($id);
    }

    public function findByName(string $name): ?Queue
    {
        return $this->newQuery()->firstWhere('name', $name);
    }

    public function findByRoom(int $roomId)
    {
        return $this->newQuery()->where('room_id', $roomId)->get();
    }

    public function findByCreator(int $userId)
    {
        return $this->newQuery()->where('user_id', $userId)->get();
    }
}

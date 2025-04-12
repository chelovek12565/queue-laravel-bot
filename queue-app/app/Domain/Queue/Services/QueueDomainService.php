<?php

namespace App\Domain\Queue\Services;

use App\Domain\Queue\DTO\QueueDTO;
use App\Domain\Queue\Entities\Queue;

class QueueDomainService
{
    public function __construct(
    )
    {
    }

    public function create(QueueDTO $dto): Queue
    {
        $queue = new Queue();
        $this->update($queue, $dto);
        return $queue;
    }

    public function update(Queue $queue, QueueDTO $dto): void
    {
        $queue->name = $dto->name;
        $queue->user_id = $dto->userId;
        $queue->room_id = $dto->roomId;

        $queue->save();
    }
}

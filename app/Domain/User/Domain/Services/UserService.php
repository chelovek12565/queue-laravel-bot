<?php

namespace App\Domain\User\Domain\Services;

use App\Domain\Queue\Repositories\QueueRepository;
use App\Domain\User\Domain\Repositories\UserRepository;
use App\Domain\Room\Repositories\RoomRepository;


class UserService
{
    public function __construct(
        private UserRepository  $userRepository,
        private RoomRepository  $roomRepository,
        private QueueRepository $queueRepository
    )
    {
    }

    public function assignToRoom(int $userId, int $roomId)
    {
        $room = $this->roomRepository->find($roomId);

        try {
            $room->users()->attach($userId);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function removeFromRoom(int $userId, int $roomId)
    {
        $user = $this->userRepository->find($userId);
        $room = $this->roomRepository->find($roomId);

        if ($user && $room) {
            $user->rooms()->detach($room);
            $user->save();
        } else {
            throw new \Exception('User or room not found');
        }
    }

    public function assignToQueue($userId, $queueId) {
        $user = $this->userRepository->find($userId);
        $queue = $this->queueRepository->find($queueId);

        if ($user && $queue) {
            $user->queues()->attach($queue, ['position' => $queue->maxPosition() + 1]);
        } else {
            throw new \Exception('User or queue not found');
        }
    }

    public function removeFromQueue($userId, $queueId) {
    $queue = $this->queueRepository->find($queueId);
    $user = $queue->users->where('id', $userId)->first();

        if ($user && $queue) {
            $user->queues()->detach($queue);
            $queue->decreasePositionHigherThan($user->pivot->position);
        } else {
            throw new \Exception('User or queue not found');
        }
    }
}

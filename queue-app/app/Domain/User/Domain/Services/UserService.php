<?php

namespace App\Domain\User\Domain\Services;

use App\Domain\User\Domain\Entities\User;
use App\Domain\Room\Entities\Room;
use App\Domain\User\Domain\Repositories\UserRepository;
use App\Domain\Room\Repositories\RoomRepository;


class UserService 
{
    public function __construct(
        private UserRepository $userRepository,
        private RoomRepository $roomRepository,
    )
    {
    }

    public function assignToRoom($userId, $roomId)
    {
        $user = $this->userRepository->find($userId);
        $room = $this->roomRepository->find($roomId);

        if ($user && $room) {
            $user->rooms()->attach($room);
        } else {
            throw new \Exception('User or room not found');
        }
    }

    public function removeFromRoom($userId, $roomId)
    {
        $user = $this->userRepository->find($userId);
        $room = $this->roomRepository->find($roomId);

        if ($user && $room) {
            $user->rooms()->detach($room);
        } else {
            throw new \Exception('User or room not found');
        }
    }
}
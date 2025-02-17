<?php

namespace App\Domain\Room\Services;

use App\Domain\Room\DTO\RoomDTO;
use App\Domain\Room\Entities\Room;
use App\Domain\User\Domain\Repositories\UserRepository;
use App\Domain\User\Domain\Services\UserService;

class RoomDomainService
{
    public function __construct(
        private UserService $userService
    )
    {
    }

    public function create(RoomDTO $dto): Room
    {
        $room = new Room();
        $this->update($room, $dto);

        $this->userService->assignToRoom($dto->userId, $room->id);

        return $room;
    }

    public function update(Room $room, RoomDTO $dto): void
    {
        $room->name = $dto->resolve($dto->name, $room->name);
        $room->description = $dto->resolve($dto->description, $room->description);
        $room->user_id = $dto->resolve($dto->userId, $room->user_id);

        $room->save();
    }

}

<?php

namespace App\Filament\Admin\Resources\RoomResource\Pages;

use App\Filament\Admin\Resources\RoomResource;
use App\Domain\Room\Services\RoomDomainService;
use App\Domain\Room\Entities\Room;
use App\Domain\Room\DTO\RoomDTO;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Container\BindingResolutionException;
use Spatie\LaravelData\Optional;
use App\Domain\User\Domain\Services\UserService;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;

    protected function handleRecordCreation(array $data): Room
    {
        try {
            $roomDomainService = app()->make(RoomDomainService::class);
            // $userService = app()->make(UserService::class);

            $roomDTO = new RoomDTO($data['user_id'], $data['name'], $data['description'] ? $data['description'] : Optional::create());
            $room = $roomDomainService->create($roomDTO);

            // try {
            //     $userService->assignToRoom($data['user_id'], $room->id);
            // } catch (\Exception $e) {
            //     Log::info($e->getMessage());
            // }
            // $userService->assignToRoom($data['user_id'], $room->id);

            return $room;
        } catch (BindingResolutionException $e) {
            throw $e;
        }
    }
}

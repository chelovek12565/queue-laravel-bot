<?php

namespace App\Http\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Room\Repositories\RoomRepository;
use App\Http\Api\Presenters\RoomPresenter;
use App\Domain\Room\Services\RoomDomainService;
use App\Http\Requests\RoomRequest;

class RoomController extends Controller
{
    public function __construct(
        private RoomRepository $roomRepository,
        private RoomDomainService $roomDomainService,
    )
    {
    }

    public function show(int $roomId)
    {
        $room = $this->roomRepository->find($roomId);
        if (!$room) {
            return response()->json([
               'success' => false,
               'message' => 'Room not found',
            ], 404);
        }

        return response()->json([
           'success' => true,
            'data' => new RoomPresenter($room),
        ], 200);
    }

    public function create(RoomRequest $request)
    {
        $room = $this->roomDomainService->create($request->toDTO());
        return response()->json([
           'success' => true,
            'data' => new RoomPresenter($room),
        ], 201);
    }

    public function update(RoomRequest $request, int $roomId)
    {
        $room = $this->roomRepository->find($roomId);
        if (!$room) {
            return response()->json([
               'success' => false,
               'message' => 'Room not found',
            ], 404);
        }

        $this->roomDomainService->update($room, $request->toDTO());

        return response()->json([
           'success' => true,
            'data' => new RoomPresenter($room),
        ], 200);
    }

    public function delete(int $roomId)
    {
        $room = $this->roomRepository->find($roomId);
        if (!$room) {
            return response()->json([
               'success' => false,
               'message' => 'Room not found',
            ], 404);
        }

        $room->delete();

        return response()->json([
           'success' => true,
           'message' => 'Room deleted successfully',
        ], 200);
    }

}

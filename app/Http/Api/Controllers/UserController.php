<?php

namespace App\Http\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\User\Domain\Services\UserDomainService;
use App\Domain\User\Domain\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Api\Presenters\UserPresenter;

class UserController extends Controller
{
    public function __construct(
        private UserDomainService $userDomainService,
        private UserService $userService
    )
    {
    }

    public function store(UserRequest $request)
    {
        $user = $this->userDomainService->store($request->toDTO());

        return $this->asJson([
            'success' => true,
            'data'    => UserPresenter::make($user),
        ]);

    }
    public function assignToRoom(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $roomId = $request->input('room_id');

            $this->userService->assignToRoom($userId, $roomId);

            return $this->asJson([
                'success' => true,
                'message' => 'User successfully assigned to room',
            ]);
        } catch (\Exception $e) {
            return $this->asJson([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function removeFromRoom(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $roomId = $request->input('room_id');

            $this->userService->removeFromRoom($userId, $roomId);

            return $this->asJson([
                'success' => true,
                'message' => 'User successfully removed from room',
            ]);
        } catch (\Exception $e) {
            return $this->asJson([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function assignToQueue(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $queueId = $request->input('queue_id');

            $this->userService->assignToQueue($userId, $queueId);

            return $this->asJson([
                'success' => true,
                'message' => 'User successfully assigned to queue',
            ]);
        } catch (\Exception $e) {
            return $this->asJson([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function removeFromQueue(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $queueId = $request->input('queue_id');

            $this->userService->removeFromQueue($userId, $queueId);

            return $this->asJson([
                'success' => true,
                'message' => 'User successfully removed from queue',
            ]);
        } catch (\Exception $e) {
            return $this->asJson([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }


}

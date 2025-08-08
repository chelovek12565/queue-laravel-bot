<?php

namespace App\Http\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Api\Presenters\UserPresenter;
use App\Services\TelegramAuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private TelegramAuthService $telegramAuthService
    ) {
    }

    /**
     * Login user by Telegram ID
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'tgid' => 'required|integer',
            'first_name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
        ]);

        $userData = [
            'first_name' => $request->input('first_name'),
            'second_name' => $request->input('second_name'),
            'username' => $request->input('username'),
        ];

        $user = $this->telegramAuthService->authenticateByTgid(
            $request->input('tgid'),
            $userData
        );

        if ($user) {
            return $this->asJson([
                'success' => true,
                'message' => 'User authenticated successfully',
                'data' => UserPresenter::make($user)
            ]);
        }

        return $this->asJson([
            'success' => false,
            'message' => 'Authentication failed'
        ], 401);
    }

    /**
     * Get current authenticated user
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = $this->telegramAuthService->getCurrentUser();

        if (!$user) {
            return $this->asJson([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        return $this->asJson([
            'success' => true,
            'data' => UserPresenter::make($user)
        ]);
    }

    /**
     * Check if user is authenticated by Telegram ID
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkAuth(Request $request): JsonResponse
    {
        $request->validate([
            'tgid' => 'required|integer',
        ]);

        $isAuthenticated = $this->telegramAuthService->isAuthenticatedByTgid(
            $request->input('tgid')
        );

        return $this->asJson([
            'success' => true,
            'data' => [
                'authenticated' => $isAuthenticated
            ]
        ]);
    }
}

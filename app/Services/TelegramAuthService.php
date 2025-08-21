<?php

namespace App\Services;

use App\Domain\User\Domain\Entities\User;
use Illuminate\Support\Facades\Auth;

class TelegramAuthService
{
    /**
     * Authenticate user by Telegram ID
     *
     * @param int $tgid
     * @param array $userData
     * @return User|null
     */
    public function authenticateByTgid(int $tgid, array $userData = []): ?User
    {
        // Find or create user by Telegram ID
        $user = User::createOrUpdateByTgid($tgid, $userData);
        
        if ($user) {
            // Regenerate session and login the user using the telegram guard
            request()->session()->regenerate();
            Auth::guard('telegram')->login($user);
            return $user;
        }
        
        return null;
    }

    /**
     * Check if user is authenticated by Telegram ID
     *
     * @param int $tgid
     * @return bool
     */
    public function isAuthenticatedByTgid(int $tgid): bool
    {
        $user = Auth::guard('telegram')->user();
        return $user && $user->tgid === $tgid;
    }

    /**
     * Get authenticated user by Telegram ID
     *
     * @param int $tgid
     * @return User|null
     */
    public function getUserByTgid(int $tgid): ?User
    {
        return User::findByTgid($tgid);
    }

    /**
     * Get current authenticated user from telegram guard
     *
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return Auth::guard('telegram')->user();
    }
}

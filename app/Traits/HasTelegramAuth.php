<?php

namespace App\Traits;

use App\Domain\User\Domain\Entities\User;
use Illuminate\Support\Facades\Auth;

trait HasTelegramAuth
{
    /**
     * Get the currently authenticated Telegram user
     *
     * @return User|null
     */
    protected function getTelegramUser(): ?User
    {
        return Auth::guard('telegram')->user();
    }

    /**
     * Get the Telegram ID of the currently authenticated user
     *
     * @return int|null
     */
    protected function getTelegramUserId(): ?int
    {
        $user = $this->getTelegramUser();
        return $user ? $user->tgid : null;
    }

    /**
     * Check if the current user is authenticated via Telegram
     *
     * @return bool
     */
    protected function isTelegramAuthenticated(): bool
    {
        return Auth::guard('telegram')->check();
    }

    /**
     * Require Telegram authentication or return 401
     *
     * @return User
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function requireTelegramAuth(): User
    {
        $user = $this->getTelegramUser();
        
        if (!$user) {
            abort(401, 'Telegram authentication required');
        }
        
        return $user;
    }
}

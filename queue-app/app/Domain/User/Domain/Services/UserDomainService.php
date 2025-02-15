<?php

namespace App\Domain\User\Domain\Services;

use App\Domain\User\Domain\DTO\UserDTO;
use App\Domain\User\Domain\Entities\User;
use App\Domain\User\Domain\Repositories\UserRepository;

class UserDomainService
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function store(UserDTO $dto): User
    {
        $user = $this->userRepository->findByTgid($dto->tgid);

        if (!$user) {
            $user = new User();
        }

        $this->update($user, $dto);
        return $user;
    }

    public function update(User $user, UserDTO $dto): void 
    {
        $user->tgid = $dto->resolve($dto->tgid, $user->tgid);
        $user->first_name = $dto->resolve($dto->firstName, $user->first_name);
        $user->second_name = $dto->resolve($dto->secondName, $user->second_name);
        $user->username = $dto->resolve($dto->username, $user->username);

        $user->save();
    }
}
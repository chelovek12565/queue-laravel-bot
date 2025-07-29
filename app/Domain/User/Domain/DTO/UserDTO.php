<?php

namespace App\Domain\User\Domain\DTO;

use App\Base\BaseDTO;
use Spatie\LaravelData\Optional;

class UserDTO extends BaseDTO
{
    public function __construct(
        public int|Optional $tgid,
        public string $firstName,
        public string|Optional $secondName,
        public string|Optional $username,
    ) {
    }
}
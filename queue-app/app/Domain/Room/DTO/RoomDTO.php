<?php

namespace App\Domain\Room\DTO;

use App\Base\BaseDTO;
use Spatie\LaravelData\Optional;

class RoomDTO extends BaseDTO
{
    public function __construct(
        public int $userId,
        public string $name,
        public string|Optional $description,
    ) {
    }
}

<?php

namespace App\Domain\Queue\DTO;

use App\Base\BaseDTO;

class QueueDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public int $userId,
        public int $roomId,
    ) {
    }
}

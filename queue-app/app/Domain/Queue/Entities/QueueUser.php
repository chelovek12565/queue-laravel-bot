<?php

namespace App\Domain\Queue\Entities;

use App\Domain\Queue\Entities\Queue;
use App\Domain\User\Domain\Entities\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class QueueUser extends Pivot
{
    public $incrementing = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function queue(): BelongsTo
    {
        return $this->belongsTo(Queue::class);
    }
}

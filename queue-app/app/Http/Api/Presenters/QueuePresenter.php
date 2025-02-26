<?php

namespace App\Http\Api\Presenters;

use App\Domain\Queue\Entities\Queue;
use App\Http\Api\Presenters\UserPresenter;
use App\Http\Api\Presenters\RoomShortPresenter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Queue
 */
class QueuePresenter extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'creator'    => new UserPresenter($this->creator),
            'room'       => new RoomShortPresenter($this->room),
            'users'      => UserPresenter::collection($this->users),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Api\Presenters;

use App\Domain\Room\Entities\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Room
 */
class RoomShortPresenter extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'creator'     => new UserShortPresenter($this->creator),
        ];
    }
}

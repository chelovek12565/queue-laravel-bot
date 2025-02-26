<?php

namespace App\Http\Api\Presenters;

use App\Domain\User\Domain\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserPresenter extends JsonResource
{

    public function toArray(Request $request): array
    {
        $data = [
            'id'          => $this->id,
            'tgid'        => $this->tgid,
            'first_name'  => $this->first_name,
            'second_name' => $this->second_name,
            'username'    => $this->username,
            'updated_at'  => $this->updated_at,
            'created_at'  => $this->created_at
        ];

        if ($this->pivot) {
            if ($this->pivot->position) {
                $data['position'] = $this->pivot->position;
            }
        }

        return $data;

    }
}

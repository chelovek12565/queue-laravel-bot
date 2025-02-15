<?php

namespace App\Http\Presenters;

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
        return [
            'id'          => $this->id,
            'tgid'        => $this->tgid,
            'first_name'  => $this->first_name,
            'second_name' => $this->second_name,
            'username'    => $this->username,
            'created_at'  => $this->created_at->toISOString(),
            'updated_at'  => $this->updated_at->toISOString(),
        ];
    }
}
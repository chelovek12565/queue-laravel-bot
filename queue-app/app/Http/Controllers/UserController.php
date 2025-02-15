<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\User\Domain\Services\UserDomainService;
use App\Http\Requests\UserRequest;
use App\Http\Presenters\UserPresenter;

class UserController extends Controller
{
    public function __construct(
        private UserDomainService $userDomainService
    )
    {
    }

    public function store(UserRequest $request)
    {
        $user = $this->userDomainService->store($request->toDTO());

        return $this->asJson([
            'success' => true,
            'data'    => UserPresenter::make($user),
        ]);

    }
}

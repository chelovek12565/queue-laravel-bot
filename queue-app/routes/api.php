<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\UserController;

Route::group(['prefix' => 'user'], function () {
    Route::put('store', [UserController::class, 'store']);
});;

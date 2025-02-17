<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\UserController;
use App\Http\Api\Controllers\RoomController;

Route::group(['prefix' => 'user'], function () {
    Route::put('store', [UserController::class, 'store']);
});;

Route::group(['prefix' => 'room', 'controller' => RoomController::class], function () {
    Route::get('{id}', 'show');
    Route::post('', 'create');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'delete');
});

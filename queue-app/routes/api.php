<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\UserController;
use App\Http\Api\Controllers\RoomController;

Route::group(['prefix' => 'user', 'controller' => UserController::class], function () {
    Route::put('store', 'store');
    Route::put('assign', 'assignToRoom');
    Route::put('remove', 'removeFromRoom');
});;

Route::group(['prefix' => 'room', 'controller' => RoomController::class], function () {
    Route::get('{id}', 'show');
    Route::post('', 'create');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'delete');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\UserController;
use App\Http\Api\Controllers\RoomController;
use App\Http\Api\Controllers\QueueController;

Route::group(['prefix' => 'user', 'controller' => UserController::class], function () {
    Route::put('store', 'store');
    Route::put('room/assign', 'assignToRoom');
    Route::put('room/remove', 'removeFromRoom');
    Route::put('queue/assign', 'assignToQueue');
    Route::put('queue/remove', 'removeFromQueue');
});

Route::group(['prefix' => 'room', 'controller' => RoomController::class], function () {
    Route::get('{id}', 'show');
    Route::post('', 'create');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'delete');
});

Route::group(['prefix' => 'queue', 'controller' => QueueController::class], function () {
    Route::get('{id}', 'show');
    Route::post('', 'create');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'delete');
    });

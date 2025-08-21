<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\Controllers\UserController;
use App\Http\Api\Controllers\RoomController;
use App\Http\Api\Controllers\QueueController;
use App\Http\Api\Controllers\AuthController;

// Authentication routes
Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('telegram.auth');
    Route::get('me', 'me')->middleware('telegram.auth');
    Route::post('check', 'checkAuth');
});

// Public user routes
Route::group(['prefix' => 'user', 'controller' => UserController::class], function () {
    Route::put('store', 'store');
});

// Protected routes (require Telegram authentication)
Route::group(['middleware' => 'telegram.auth'], function () {
    Route::group(['prefix' => 'user', 'controller' => UserController::class], function () {
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
});

<?php

use App\Domain\Room\Entities\Room;
use App\Domain\Queue\Entities\Queue;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rooms/{id}', function (string $id) {
    return view('room', ['room' => Room::all()->findOrFail($id)]);
})->name('room');

Route::get('/queue/{id}', function (string $id) {
    return view('queue', ['queue' => Queue::all()->findOrFail($id)]);
})->name('queue');

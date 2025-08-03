<?php

use App\Domain\Room\Entities\Room;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rooms/{id}', function (string $id) {
    return view('room', ['room' => Room::with('users')->findOrFail($id)]);
});

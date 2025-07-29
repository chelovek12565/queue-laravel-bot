<?php

namespace App\Livewire\Container;

use Livewire\Component;
use Livewire\Attributes\On;

class RoomContainer extends Component
{
    public $rooms = [];

    #[On('userDataLoaded')]
    public function handleUserData($user)
    {
        $this->rooms = $user['rooms'];
    }

    public function render()
    {
        return view('livewire.container.room-container');
    }
}

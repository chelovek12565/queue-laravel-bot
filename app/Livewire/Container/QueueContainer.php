<?php

namespace App\Livewire\Container;

use Livewire\Component;
use Livewire\Attributes\On;

class QueueContainer extends Component
{
    public $queues = [];

    #[On('userDataLoaded')]
    public function handleUserData($user)
    {
        $this->queues = $user['queues'];
    }

    public function render()
    {
        return view('livewire.container.queue-container');
    }
}

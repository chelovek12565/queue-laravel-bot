<?php

namespace App\Livewire\Container;

use Livewire\Component;
use App\Domain\Queue\Entities\Queue;
use Livewire\Attributes\On;

class QueueUsersContainer extends Component
{
    public $queueId;
    public $users = [];
    public $isEmpty = true;

    public function mount($queueId)
    {
        $this->queueId = $queueId;
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $queue = Queue::with('users')->find($this->queueId);
        
        if ($queue) {
            $this->users = $queue->users->sortBy('pivot.position')->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->second_name,
                    'position' => $user->pivot->position
                ];
            })->toArray();
            
            $this->isEmpty = empty($this->users);
        }
    }

    #[On('refresh-queue-users')]
    public function refresh()
    {
        $this->loadUsers();
    }

    public function render()
    {
        return view('livewire.container.queue-users-container');
    }
}

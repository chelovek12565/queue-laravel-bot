<div wire:poll.3s>
    @foreach ($rooms as $room)
        @livewire('card', [
            'title' => $room['name'],
            'text'  => $room['description'],
            'link'  => "/rooms/{$room['id']}"
            ], key($room['id']))
    @endforeach
</div>

<div>
    @foreach ($queues as $queue)
        @livewire('card', [
            'title' => $queue['title'],
            'text'  => $queue['text'],
            'link'  => "/queues/{$queue['id']}"
            ], key($queue['id']))
    @endforeach
</div>

<div wire:poll.2s>
    @if($isEmpty)
        <p class="card-text">В этой очереди пока нет участников.</p>
    @else
        <ul class="list-group">
            @foreach($users as $user)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $user['name'] }}</span>
                    <span class="badge bg-primary rounded-pill">{{ $user['position'] }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>

@extends('app')

@section('title')
{{'Очередь ' . $queue->name}}
@endsection

@section('linksAndStyles')
<!-- <link href="{{mix('css/room.css')}}" rel="stylesheet"> -->
@endsection

@section('content')
<div class="card text-center">
  <div class="card-header">
    <h5 class="card-title mb-0">{{ $queue->name }}</h5>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-8">
        <h6>Участники очереди</h6>
        @if($queue->users->isEmpty())
          <p class="card-text">В этой очереди пока нет участников.</p>
        @else
          <ul class="list-group">
            @foreach($queue->users->sortBy('pivot.position') as $user)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                  @if($user->username)
                    {{ $user->username }}
                  @else
                    {{ $user->first_name }} {{ $user->second_name }}
                  @endif
                </span>
                <span class="badge bg-primary rounded-pill">{{ $user->pivot->position }}</span>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h6>Информация об очереди</h6>
            <p><strong>Создатель:</strong><br>
              @if($queue->creator->username)
                {{ $queue->creator->username }}
              @else
                {{ $queue->creator->first_name }} {{ $queue->creator->second_name }}
              @endif
            </p>
            <p><strong>Комната:</strong><br>
              <a href="{{ route('room', $queue->room->id) }}">{{ $queue->room->name }}</a>
            </p>
            <p><strong>Создана:</strong><br>
              {{ $queue->created_at->format('d.m.Y H:i') }}
            </p>
            <p><strong>Участников:</strong> {{ $queue->users->count() }}</p>
          </div>
        </div>
      </div>
    </div>
    
    <div class="mt-3">
      <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        <a href="#" class="btn btn-primary">Присоединиться к очереди</a>
      </div>
    </div>
  </div>
</div>
@endsection 
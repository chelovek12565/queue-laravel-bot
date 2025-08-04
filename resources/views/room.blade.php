@extends('app')

@section('title')
{{'Комната ' . $room->name}}
@endsection

@section('linksAndStyles')

<link href="{{mix('css/room.css')}}" rel="stylesheet">

@endsection

@section('content')
<div class="card text-center">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" id="roomTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="participants-tab" data-bs-toggle="tab" data-bs-target="#participants" type="button" role="tab" aria-controls="participants" aria-selected="true">
          Участники
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="queues-tab" data-bs-toggle="tab" data-bs-target="#queues" type="button" role="tab" aria-controls="queues" aria-selected="false">
          Очереди
        </button>
      </li>
    </ul>
  </div>
  <div class="card-body tab-content" id="roomTabContent">
    <div class="tab-pane fade show active" id="participants" role="tabpanel" aria-labelledby="participants-tab">
      <div class="d-grid gap-2 mx-auto">
        <a href="#" class="btn btn-primary">Добавить участника</a>
      </div>
      @if($room->users->isEmpty())
        <p class="card-text">В этой комнате пока нет участников.</p>
      @else
        <ul class="list-group">
          @foreach($room->users as $user)
            <li class="list-group-item">
              @if($user->username)
                {{ $user->username }}
              @else
                {{ $user->first_name }} {{ $user->second_name }}
              @endif
            </li>
          @endforeach
        </ul>
      @endif
    </div>
    <div class="tab-pane fade" id="queues" role="tabpanel" aria-labelledby="queues-tab">
      <div class="d-grid gap-2 mx-auto">
        <a href="#" class="btn btn-primary">Создать очередь</a>
      </div>
      @if($room->queues->isEmpty())
        <p class="card-text">В этой комнате пока нет очередей.</p>
      @else
        <ul class="list-group">
          @foreach($room->queues as $queue)
            <li class="list-group-item">
              <div class="d-flex justify-content-between align-items-center" href="{{ route('queue', $queue->id) }}">
                <span>{{ $queue->name }}</span>
                <small class="text-muted">
                  Создатель: 
                  @if($queue->creator->username)
                    {{ $queue->creator->username }}
                  @else
                    {{ $queue->creator->first_name }} {{ $queue->creator->second_name }}
                  @endif
                </small>
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</div>
@endsection

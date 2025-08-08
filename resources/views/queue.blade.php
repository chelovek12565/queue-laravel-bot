@extends('app')

@section('title')
{{'Очередь ' . $queue->name}}
@endsection

@section('linksAndStyles')
<script href="{{mix('js/queue.js')}}"></script>
@endsection

@section('content')
<div class="card text-center">
  <div class="card-header">
    <h5 class="card-title mb-0">{{ $queue->name }}</h5>
  </div>

  <div class="mt-3">
      <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        @php
          $currentUserId = auth()->id();
          $isUserInQueue = $currentUserId ? $queue->users->contains('id', $currentUserId) : false;
        @endphp
        <button type="button" class="btn {{ $isUserInQueue ? 'btn-danger' : 'btn-primary' }}" 
                onclick="toggleQueueMembership({{ $queue->id }}, {{ $isUserInQueue ? 'true' : 'false' }})">
          {{ $isUserInQueue ? 'Покинуть очередь' : 'Присоединиться к очереди' }}
        </button>
      </div>
    </div>
    
  <div class="card-body">
    <div class="row">
      <div class="col-md-8">
        <h6>Участники очереди</h6>
        @livewire('container.queue-users-container', ['queueId' => $queue->id])
      </div>
    </div>

  </div>
</div>
@endsection 
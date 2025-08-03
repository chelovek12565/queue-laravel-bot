@extends('app')

@section('title')
{{'Комната ' . $room->name}}
@endsection

@section('content')
<div class="container mt-4">
    <div class="row mb-3">
        <div class="col">
            <button class="btn btn-primary">
                Добавить участника
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Участники</h5>
                </div>
                <div class="card-body">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="participantsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Показать участников ({{ $room->users->count() }})
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="participantsDropdown">
                            @forelse($room->users as $user)
                                <li><a class="dropdown-item" href="#">
                                    @if($user->username)
                                        {{ $user->username }}
                                    @else
                                        {{ $user->first_name }}
                                        @if($user->second_name)
                                            {{ $user->second_name }}
                                        @endif
                                    @endif
                                </a></li>
                            @empty
                                <li><span class="dropdown-item text-muted">Нет участников</span></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

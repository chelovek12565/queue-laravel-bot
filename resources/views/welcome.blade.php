@extends('app')

@section('title', 'Комнаты')

@section('linksAndStyles')

<script src="{{mix('js/welcome.js')}}"></script>
<link href="{{mix('css/welcome.css')}}" rel="stylesheet">

@endsection

@section('content')

<h3 style="display: none" id="welcomeEmptyRoomsHeader">Похоже вы не состоите ни в какой комнате! Для начала работы с приложением, создайте свою комнату, или присоединитесь к уже существующей.</h3>

<div class="d-grid gap-2 mx-auto">
    <button class="btn btn-primary" type="button" id="showCreateRoomFormBtn">Создать комнату</button>
</div>

<form id="createRoomForm" style="display: none; margin: 2em 10% 2em 10%" method="POST">
    <div class="mb-3">
        <label for="roomName" class="form-label">Название комнаты</label>
        <input type="text" class="form-control" id="roomName" name="name" required maxlength="255">
    </div>
    <div class="mb-3">
        <label for="roomDescription" class="form-label">Описание (необязательно)</label>
        <textarea class="form-control" id="roomDescription" name="description" rows="2"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Создать</button>
    <button type="button" class="btn btn-secondary" id="cancelCreateRoomFormBtn">Отмена</button>
</form>

<h6 id="welcomeRoomsHeader" style="display: none">Вот комнаты, в которых вы состоите</h6>

<livewire:container.room-container />

@endsection

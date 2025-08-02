@extends('app')

@section('title', 'Комнаты')

@section('linksAndStyles')

<script src="{{mix('js/welcome.js')}}"></script>
<link href="{{mix('css/welcome.css')}}" rel="stylesheet">

@endsection

@section('content')

<h3 style="display: none" id="welcomeEmptyRoomsHeader">Похоже вы не создадите ни в какой комнате! Для начала работы с приложением, <a href="/rooms">создайте свою комнату</a>, или присоединитесь к уже существующей.</h3>

<div class="d-grid gap-2 mx-auto">
    <button class="btn btn-primary" type="button">Создать комнату</button>
</div>

<h6 id="welcomeRoomsHeader" style="display: none">Вот комнаты, в которых вы состоите</h6>

<livewire:container.room-container />

@endsection

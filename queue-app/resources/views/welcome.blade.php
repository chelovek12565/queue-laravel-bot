@extends('app')

@section('title', 'Home Page')

@section('linksAndStyles')

<script src="{{mix('js/welcome.js')}}"></script>

@endsection

@section('content')

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    </div>
  </div>

{{-- <button class="btn success toggle-queue" type="button"> Toggle</button> --}}

@endsection

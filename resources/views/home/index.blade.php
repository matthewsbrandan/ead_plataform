@extends('layout.app')
@section('head')
  <title>Home | {{ config('app.name') }}</title>
  @php  $sidebarActive = 'home' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Home</h1>
  </div>
@endsection
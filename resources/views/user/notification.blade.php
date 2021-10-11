@extends('layout.app')
@section('head')
  <title>Notificações | {{ config('app.name') }}</title>
  @php  $sidebarActive = 'profile' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Notificações</h1>
  </div>
@endsection
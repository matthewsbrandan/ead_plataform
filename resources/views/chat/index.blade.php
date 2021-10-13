@extends('layout.app')
@section('head')
  <title>Chats | {{ config('app.name') }}</title>
  @php  $sidebarActive = 'chats' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Chats</h1>
  </div>
@endsection
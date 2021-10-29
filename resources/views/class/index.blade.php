@extends('class.partials.app')
@section('head')
  <title>{{ $course->title }} | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/class/about.css') }}">
  @php  $sidebarActive = 'chats' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>{{ $course->title }}</h1>
  </div>
@endsection
@extends('layout.app')
@section('head')
  <title>Meus Cursos | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/course.css') }}">
  @php  $sidebarActive = 'course' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Meus Cursos</h1>
    @include('course.partials.nav',['active' => 'mine'])

    {{ var_dump($courses->toArray()) }}
  </div>
@endsection
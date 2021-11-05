@extends('layout.app')
@section('head')
  <title>Home | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/home.css') }}">
  @php  $sidebarActive = 'home' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Home Test</h1>
    <div class="card-courses">
      <strong>Últimos cursos que você ingressou</strong>
      <ul>
        @foreach(auth()->user()->coursesPivot()->orderBy('created_at', 'desc')->take(10)->get() as $student)
          <li>
            <img src="{{$student->course->wallpaper}}" alt="{{$student->course->title}}"/>
            <span>{{$student->course->title}}</span>
            <time>{{$student->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i')}}</time>
          </li>
        @endforeach
      </ul>
    </div>
    <div class="card-courses-completed">
      <strong>Cursos que você completou</strong>
      <div class="container">
        @foreach($coursesCompleted as $course)
          <div class="card">
            <img src="{{ $course->course->wallpaper}}"/>
            <strong>{{ $course->course->title }}</strong>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
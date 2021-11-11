@extends('layout.app')
@section('head')
  <title>Home | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/home.css') }}">
  @php  $sidebarActive = 'home' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Home</h1>
    <div class="card-courses">
      <strong>Últimos cursos que você ingressou</strong>
      <ul>
        @foreach($userCourse as $student)
          <li onClick="runLoad('{{ route('class.show',['slug' => $student->course->slug]) }}')">
            <img src="{{$student->course->wallpaper}}" alt="{{$student->course->title}}"/>
            <span>{{$student->course->title}}</span>
            <time>{{$student->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i')}}</time>
          </li>
        @endforeach
        @if(count($userCourse) == 0)
          <span style="color: #99a; font-size: .8rem;">Você ainda não ingressou em nenhum curso...</span>
        @endif
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
        @if(count($coursesCompleted) == 0)
          <span style="color: #99a; font-size: .8rem;">Você ainda não completou nenhum curso...</span>
        @endif
      </div>
    </div>
  </div>
  @include('utils.loading')
@endsection
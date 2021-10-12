@extends('layout.app')
@section('head')
  <title>Cursos | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/course.css') }}">
  @php  $sidebarActive = 'course' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Cursos</h1>
    @include('course.partials.nav',['active' => 'index'])
    <div class="content-courses">
      @foreach(auth()->user()->courses as $course)
        <div class="course">
          <img src="{{ $course->wallpaper }}" alt="{{ $course->title }}"/>
          <div>
            <div class="title">
              <strong>{{ $course->title }}</strong>
              <div>
                <div class="dropdown">
                  <ul>
                    <li><a href="{{ route('course.mine.edit',['id' => $course->id]) }}">Configurações</a></li>
                    <li><a href="{{ route('lesson.create',['slug' => $course->slug]) }}">Conteúdo</a></li>
                    @if(!$course->published_at)
                      <li><a href="{{ route('course.mine.publish',['id' => $course->id]) }}">Publicar</a></li>
                    @endif
                  </ul>
                </div>
                <svg onclick="$(this).prev().toggle('slow')" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M10 10h4v4h-4zm0-6h4v4h-4zm0 12h4v4h-4z"></path></svg>
              </div>
            </div>
            <p>{{ $course->description }}</p>
            <div class="badge"> {{ $course->category->title }} </div>
            <div class="actions">
              <div>
                @if($course->rating)
                  <span>{{ $course->rating }}</span>
                @endif
                @if($course->formatDuration())
                  <span>Duração {{ $course->formatDuration() }}</span>
                @endif
                @if($course->published_at)
                  <span>Publicado em {{ $course->published_at->format('d/m/Y') }}</span>
                @endif
              </div>
              <a class="btn-primary" href="{{ route('lesson.index',['slug' => $course->slug]) }}">Acessar</a>
            </div>
          </div>
        </div>
      @endforeach
      @if(auth()->user()->courses->count() == 0)
        <p class="no-courses">Você não está matriculado em nenhum curso</p>
      @endif
    </div>
  </div>
@endsection
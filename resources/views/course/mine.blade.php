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
    <div class="content-courses">
      @foreach($courses as $course)
        <div class="course">
          <img class="course-image" src="{{ $course->wallpaper }}" alt="{{ $course->title }}"/>
          <div>
            <div class="title">
              <div>
                <strong>{{ $course->title }}</strong>
                <div class="fill-quality">
                  @php $fillQuality = $course->fillQuality(); @endphp
                  <span class="points">{{ $fillQuality->points }}</span>
                  <ul class="missions">
                    @foreach($fillQuality->missions as $mission)
                      <li>{{$mission}}</li>
                    @endforeach
                  </ul>
                </div>
              </div>

              <div>
                <div class="dropdown">
                  <ul>
                    <li><a href="{{ route('course.mine.edit',['id' => $course->id]) }}">Editar</a></li>
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
                @if($course->num_classes > 0)
                  <span>{{ $course->num_classes }} Aula(s)</span>
                @endif
                @if($course->published_at)
                  <span>Publicado em {{ $course->published_at->format('d/m/Y') }}</span>
                @endif
              </div>
              @if($course->published_at)
                <a class="btn-primary" href="{{ route('class.show',['slug' => $course->slug]) }}">Acessar</a>
              @endif
            </div>
          </div>
        </div>
      @endforeach
      @if($courses->count() == 0)
        <p class="no-courses">Nenhum curso cadastrado</p>
      @endif
    </div>
  </div>
@endsection
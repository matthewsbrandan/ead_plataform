@extends('layout.app')
@section('head')
  <title>Cursos | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/course.css') }}">
  @php  $sidebarActive = 'course' @endphp
@endsection
@section('content')
  <div class="container">
    <div style="
      display: flex;
      align-items: center;
      justify-content: space-between;
    ">
      <h1>Cursos</h1>
      <button
        class="btn-clean"
        type="button"
        onclick="help()"
      >@include('utils.icons.help')</button>
    </div>
    @include('course.partials.nav',['active' => 'index'])
    <div class="content-courses">
      @foreach($courses as $course)
        <div class="course">
          <figure class="">
            <img class="course-image" src="{{ $course->wallpaper }}" alt="{{ $course->title }}"/>
            <div class="course-progress">
              <span class="course-progress-value" style="width: {{ $course->student()->progress}}%;"></span>
            </div>
          </figure>
          <div>
            <div class="title">
              <strong>{{ $course->title }}</strong>
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
              <a class="btn-primary" href="{{ route('class.show',['slug' => $course->slug]) }}">Acessar</a>
            </div>
          </div>
        </div>
      @endforeach
      @if(count($courses) == 0)
        <p class="no-courses">Você não está matriculado em nenhum curso</p>
      @endif
    </div>
  </div>
@endsection
@section('script')
  <script>
    function help(){
      showMessage(`
        <article style="text-align: left;">
          <div style="margin-bottom: .8rem;">
            <strong>Página:</strong> Cursos.
          </div>
          <div style="margin-bottom: .8rem;">
            <strong>Descrição:</strong> Nessa página você vê todos os cursos em que você está matriculado, e caso seja usuário do tipo 'Professor', terá opções para ver seus cursos criados e um botão para criar novos cursos.
          </div>
          <div style="margin-bottom: .8rem;">
            <strong>Instruções:</strong>
            <p style="margin: .2rem 0 .6rem;">
              - Duas informações importantes no card do curso é o botão de acessar, que te redirecionará para aula, e bem no final da imagem do curso terá uma barra de progresso azul mostrando o percentual do curso que você já completou.
            </p>
          </div>
        </article>
      `, 'Auto - Ajuda');
    }
  </script>
@endsection
@extends('layout.app')
@section('head')
  <title>Meus Cursos | {{ config('app.name') }}</title>
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
      <h1>Meus Cursos</h1>
      <button
        class="btn-clean"
        type="button"
        onclick="help()"
      >@include('utils.icons.help')</button>
    </div>
    @include('course.partials.nav',['active' => 'mine'])
    <div class="content-courses">
      @foreach($courses as $course)
        <div class="course">
          <figure>
            <img class="course-image" src="{{ $course->wallpaper }}" alt="{{ $course->title }}"/>
          </figure>
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
                  <span>
                    {{ $course->rating }}
                    @include('utils.icons.star',['icon' => (object)[
                      'width' => 14, 'height' => 14,
                      'style' => 'vertical-align: -2px;'
                    ]])
                  </span>
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
@section('script')
  <script>
    function help(){
      $('#modalMessage .container').css('max-width','55rem');
      showMessage(`
        <article style="text-align: left;">
          <div style="margin-bottom: .8rem;">
            <strong>Página:</strong> Meus Cursos.
          </div>
          <div style="margin-bottom: .8rem;">
            <strong>Descrição:</strong> Nessa página você vê todos os cursos que você criou,além de ter um menu de opções para ver os cursos que você está matriculado e um botão para criar novos cursos.
          </div>
          <div style="margin-bottom: .8rem;">
            <strong>Instruções:</strong>
            <p style="margin: .2rem 0 .6rem;">
              - Como já dito, para criar um novo curso há um link "Novo Curso" que te redirecionará para a página de criação
            </p>
            <p style="margin-bottom: .6rem;">
              - Na frente do titulo do curso haverá um círculo com um número (0 - 100) que corresponde à porcentagem de preenchimento do curso, e caso você passe o mouse por cima, verá quais são as ações necessárias para chegar a 100%.
            </p>
            <p style="margin-bottom: .6rem;">
              - Na parte superior direita do card do curso tem três pontinhos na vertical, que mostra algumas opções que você pode acessar, que são: 'Editar', 'Conteúdo' e 'Publicar' (Caso seu curso ainda não esteja publicado).
            </p>
            <p style="margin-bottom: .6rem;">
              > <em>Editar:</em> Abrirá uma página em que você pode alterar as informações do grupo, como descrição, nome, e outras informações.
            </p>
            <p style="margin-bottom: .6rem;">
              > <em>Conteúdo:</em> Abrirá o painel onde você gerencia o conteúdo do curso, podendo adicionar, remover, editar, reorganizar, etc.
            </p>
            <p style="margin-bottom: .6rem;">
              > <em>Publicar:</em> Todo curso inicia no modo de edição, sendo assim, ninguém verá o seu curso, até que você clique em publicar.
            </p>
          </div>
        </article>
      `, 'Auto - Ajuda');
    }
  </script>
@endsection
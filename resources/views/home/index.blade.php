@extends('layout.app')
@section('head')
  <title>Home | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/home.css') }}">
  @php  $sidebarActive = 'home' @endphp
@endsection
@section('content')
  <div class="container">
    <div style="
      display: flex;
      align-items: center;
      justify-content: space-between;
    ">
      <h1>Home</h1>
      <button
        class="btn-clean"
        type="button"
        onclick="help()"
      >@include('utils.icons.help')</button>
    </div>
    @if(config('app.beta'))
      <div style="
        background: #aad2;
        padding: 1.2rem;
        margin: 1rem 0;
        border-radius: 1rem;
        color: #667;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: max-content;
        max-width: 100%;
      ">
        <p>Responda a pesquisa e deixe sua opinião sobre a nossa plataforma.</p>
        <a
          href="{{ route('feedback.index') }}"
          class="btn-primary"
          style="
            height: 2.2rem;
            padding: 1.2rem;
            border-radius: 1rem;
            margin: .8rem 0 0;
          "
        >Deixar Feedback</a>
      </div>
    @endif
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
@section('script')
  <script>
    function help(){
      showMessage(`
        <article style="text-align: left;">
          <div style="margin-bottom: .8rem;">
            <strong>Página:</strong> Home.
          </div>
          <div style="margin-bottom: .8rem;">
            <strong>Descrição:</strong> Essa página mostra algumas informações gerais, como últimos cursos que você ingressou, e quais cursos você completou, e a opção de deixar um feedback sobre a plataforma.
          </div>
          <div style="margin-bottom: .8rem;">
            <strong>Instruções:</strong>
            <p style="margin: .2rem 0 .6rem;">
              - Na área de "cursos que você ingressou", caso haja cursos listados, você pode clicar encima deles para ser redirecionado para a sala de aula. 
            </p>
            <p style="margin-bottom: .6rem;">
              - Na lateral(ou na parte superior caso esteja no celular) há alguns icones que compoem o menu, você pode clicar neles para ser redirecionado para outras páginas. E clicando sobre o icone do seu perfil terá opções de acessar suas notificações, seu dados de perfil, ou sair da plataforma.
            </p>
          </div>
        </article>
      `, 'Auto - Ajuda');
    }
  </script>
@endsection
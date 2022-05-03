@extends('layout.app')
@section('head')
  <title>Home | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/home.css') }}">
  @php  $sidebarActive = 'home' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Home</h1>
    @if(config('app.beta') && config('app.feedback'))
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
          href="{{ config('app.feedback') }}"
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
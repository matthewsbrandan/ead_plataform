@extends('layout.app')
@section('head')
  <title>Chats | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/home.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/chat.css') }}">
  @php  $sidebarActive = 'chats' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Chats</h1>
    <div class="card-chats" id="container-questions">
      @foreach ($chats as $message)
        <div
          class="content-message {{ $message->user_id == auth()->user()->id ? 'is-me' : '' }}"
          id="message-{{$message->id}}"
          onclick="runLoad('{{ route('chat.course',['slug' => $message->course->slug, 'user_id' => $message->user_id]) }}')"
        >
          <div class="content-avatar" style="position: relative;">
            @if($message->course->user_id == auth()->user()->id)
              <img src="{{ $message->author_thumbnail }}" style="
                clip: rect(0,1.2rem,2.4rem,0);
                position: absolute;
              "/>              
              <img src="{{ $message->course->wallpaper }}" style="
                clip: rect(0,2.4rem,2.4rem,1.2rem);
                position: absolute;
              "/>
            @else
              <img src="{{ $message->course->wallpaper }}"/>
            @endif
          </div>
          <div class="message-info">
            <strong class="message-author">
              {{ $message->course->title }}
              @if($message->course->user_id == auth()->user()->id)
               | {{ $message->author_name }}
              @endif
            </strong>
            <time class="message-timestamp">
              {{ $message->date_formatted }}
            </time>
            <div class="message-body">
              {{$message->content}}
            </div>
            <div class="message-responses" id="responses-message-{{$message->breadcrumbs}}"></div>
          </div>
        </div>
      @endforeach
      @if(count($chats) == 0)
        <span style="color: #99a; font-size: .8rem;">Você ainda não ingressou em nenhum chat...</span>
      @endif
    </div>
    <div class="card-courses">
      <strong>Cursos</strong>
      <ul>
        @foreach($userCourse as $student)
          <li onclick="runLoad('{{ route('chat.course',['slug' => $student->course->slug, 'user_id' => auth()->user()->id]) }}')">
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
  </div>
  @include('utils.loading')
@endsection
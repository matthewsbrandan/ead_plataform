@extends('layout.app')
@section('head')
  <title>{{ $course->title }} | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/chat.css') }}">
  @php  $sidebarActive = 'chats' @endphp
  <style>
    #main{
      padding-bottom: .4rem !important;
    }
    #container-questions{
      gap: .4rem;
      padding-bottom: .8rem;
    }
    .content-message{
      width: fit-content;
      max-width: 80%;
      min-width: 25rem;
      border: 1px solid #dde;
      border-radius: .4rem;
      padding: 0.8rem;
    }
    .content-message.is-me{
      align-self: flex-end;
    }
    #group-question{
      position: relative;
      width: 100%;
    }
    #text-question{
      border: 1px solid #dde;
      border-radius: .4rem;
      width: 100%;
      padding: 0.8rem;
    }
    #group-question .btn-primary{
      position: absolute;
      bottom: .8rem;
      right: .4rem;
    }
  </style>
@endsection
@section('content')
  <div class="container" style="overflow: hidden; height: calc(100vh - 1.8rem);">
    <div style="height: calc(100vh - 150px); overflow-x: auto;">
      <h1 class="text-ellipsis">Chat | {{ $course->title }}</h1>
      @if($chats->count() > 0)
        <span id="more-messages" onClick="loadTeacherMessages()">Carregar mais...</span>
      @endif
      <div id="container-questions">
        @foreach($chats as $message)
          <div
            class="content-message {{
              ($message->is_course && $message->user_id !== auth()->user()->id) ||
              (!$message->is_course && $message->user_id === auth()->user()->id) ? 'is-me' : ''
            }}"
            id="message-{{$message->id}}"
          >
            <div class="content-avatar">
              <img
                src="{{ $message->author_thumbnail }}"
              />
            </div>
            <div class="message-info">
              <strong class="message-author">{{ $message->author_name }}</strong>
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
      </div>
    </div>
    <form onsubmit="return sendMessage(event);">
      <div class="form-group" id="group-question">
        <textarea
          id="text-question"
          class="form-control"
          placeholder="Deixe aqui suas dúvidas..."
          rows="5"
          required
        ></textarea>
        <span id="text-question-error-message"></span>
        <button
          type="submit"
          class="btn-block btn-primary"
          style="height: 2rem"
        >Enviar Pergunta</button>
      </div>
    </form>
  </div>
  @include('utils.loading')
@endsection
@section('script')
  <script>
    const isChatTeacher = true;
  </script>
  @include('chat.partials.script')
@endsection
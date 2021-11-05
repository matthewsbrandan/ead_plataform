@extends('class.partials.app')
@section('head')
  <title>{{ $course->title }} | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/class/room.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @php  $sidebarActive = 'book' @endphp
@endsection
@section('content')
  <div class="container">
    <div class="content">
      <div class="header">
        <div>
          <h1>{{ $course->title }}</h1>
          <span class="text-gray-500">Professor(a): {{ $course->teacher->name }}</span>
        </div>
        <div class="actions">
          <button type="button" class="btn-clean">Avaliar</button>
          <button type="button" class="btn-clean btn-svg">@include('utils.icons.share')</button>
          <span class="porcentage">{{ $student->progress }}<small>%</small></span>
        </div>
      </div>
      <div class="container-lesson">
        <div class="current-lesson">
          <div id="lesson-container">
            {!! $currentLesson->type == 'article' ? $currentLesson->content : '' !!}
          </div>
          <ul class="lesson-options">
            <li
              class="lesson-option-item active"
              onclick="handleSelectLessonOption($(this),'#lesson-about')"
            >Sobre</li>
            <li class="lesson-option-item" onclick="handleSelectLessonOption($(this),'#lesson-questions')">Perguntas</li>
          </ul>
          <div class="toggle-option" id="lesson-about" style="display: block;">
            <h3 id="about-title">{{ $currentLesson->title }}</h3>
            <div class="about-details">
              <span id="about-time">
                <span class="value">{{ $currentLesson->formatDuration() }}</span>
              </span>
              <span id="about-views">
                <span class="value">{{ $currentLesson->num_views }}</span> 
                @include('utils.icons.eye')
              </span>
              <span id="about-rating">
                <span class="value">{{ $currentLesson->rating ?? '-' }}</span> 
                @include('utils.icons.star')
              </span>
            </div>
            <p id="about-description">
              {{ $currentLesson->description }}
            </p>
          </div>
          <div class="toggle-option" id="lesson-questions">
            <form>
              <div class="form-group">
                <textarea
                  id="text-question"
                  class="form-control"
                  placeholder="Deixe aqui suas dúvidas..."
                  rows="5"
                  required
                ></textarea>
                <button
                  type="submit"
                  class="btn-block btn-primary"
                  style="height: 2rem"
                >Enviar Pergunta</button>
              </div>
            </form>
            <div id="container-questions"></div>
          </div>
        </div>
        <nav class="nav-lesson">
          <ul class="lesson-list">
            @foreach($classes as $class)
              @if($class['type'] == 'section')
                @include('class.partials.section', ['class' => $class])
              @elseif($class['type'] == 'lesson')
                @include('class.partials.lesson', ['class' => $class])
              @endif
            @endforeach
          </ul>
        </nav>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script>
    var selectedLesson = {
      ...{!! $currentLesson->toJson() !!},
      student: {!! $currentLesson->student(true) ?? 'null' !!}
    };

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function handleSelectLessonOption(elem, target){
      $('.lesson-option-item').removeClass('active');
      elem.addClass('active');

      $('.toggle-option').hide();
      $(target).show('slow');
    }
    function handleSelectLesson(elem, lesson, duration, student = null){
      selectedLesson = {
        ...lesson,
        student
      };
      $('.lesson-item').removeClass('active');
      elem.addClass('active');

      $('#about-title').html(lesson.title);
      $('#about-time .value').html(duration);
      $('#about-views .value').html(lesson.num_views);
      $('#about-rating .value').html(lesson.rating ?? '-');
      $('#about-description').html(lesson.description);

      if(lesson.type === 'video') handleRenderYoutube(lesson);
      else if(lesson.type === 'archive') $('#lesson-container').html(
        handleArchiveToHtml(JSON.parse(lesson.content))
      );
      else $('#lesson-container').html(lesson.content);
      if(lesson.type !== 'video') setTimeout(
        () => markAsWatched(false), 3000
      );
    }
    function handleArchiveToHtml(archives){
      let html = [
        `<div class="list-archive">`,
        ...archives.map(archive => {
          return `
            <div class="archive-item">
              <a href="${archive.link}" target="_blank">Link Externo</a>
              <p>${archive.description}</p>
            </div>
          `;
        }),
        "</div>"
      ];

      return html.join('');
    }
    function handleRenderYoutube(lesson){
      let html = `<div id="player"></div>`;
      let youtube_id = lesson.url.replace('https://youtube.com/embed/','');
      
      $('#lesson-container').html(html);
      onYouTubeIframeAPIReady(youtube_id);
    }

    // BEGIN:: HANDLE YOUTUBE
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    function onYouTubeIframeAPIReady(id){
      if(!id){
        @if($currentLesson->type == 'video')
          handleRenderYoutube({!! $currentLesson->toJson() !!});
        @endif
        return;
      }
      player = new YT.Player('player', {
        height: '100%',
        width: '100%',
        videoId: id,
        events: {
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange
        }
      });
    }
    function onPlayerReady(event){ event.target.playVideo(); }
    function onPlayerStateChange(event){
      if (event.data == YT.PlayerState.ENDED) markAsWatched();
    }
    // END:: HANDLE YOUTUBE
    async function markAsWatched(next = true){
      if(!selectedLesson) return;
      if(selectedLesson.student && selectedLesson.student.viewed === 1) return;

      $.post('{{ route('class.toView',['slug' => $course->slug]) }}', {
        course_id: {{ $course->id }},
        lesson_id: selectedLesson.id,
      }).done(data => {
        if(!data.result) return;
        
        if(data.isCompleted) showMessage(
          "<h2 style='margin: -1rem 0 1rem;'>Parabéns por chegar até aqui!!<br/>🎉👏</h2>Você alcançou o final deste curso!",
          '{{ $course->title }}'
        );

        if(!next) return;

        const nextLesson = $(`#lesson-${selectedLesson.real_index + 1}`);
        console.log(nextLesson);
        if(nextLesson) nextLesson.click();
      })
    }
    $(function(){
      @if($currentLesson->type == 'archive')
        $('#lesson-container').html(handleArchiveToHtml({!! $currentLesson->content !!}));
      @endif
    });
  </script>
@endsection
@extends('layout.app')
@section('head')
  <title>Aulas | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/lesson.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/utils/loading.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
  <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
  @php  $sidebarActive = 'course' @endphp
@endsection
@section('content')
  <div class="container create-class">
    <h1>
      Aulas - <span style="color: #99a;">{{ $course->title }}</span> 
      {{ $section ? '| '.$section->title : '' }}
    </h1>
    <ul class="navbar">
      <li class="{{ $type == 'video' ? 'active': '' }}">
        <a href="{{ route('lesson.class.create',[
          'slug' => $course->slug,
          'section_id' => $section->id ?? null,
          'type' => 'video'
        ]) }}">Vídeo</a>
      </li>
      <li class="{{ $type == 'article' ? 'active': '' }}">
        <a href="{{ route('lesson.class.create',[
          'slug' => $course->slug,
          'section_id' => $section->id ?? null,
          'type' => 'article'
        ]) }}">Artigo</a>
      </li>
      <li class="{{ $type == 'archive' ? 'active': '' }}">
        <a href="{{ route('lesson.class.create',[
          'slug' => $course->slug,
          'section_id' => $section->id ?? null,
          'type' => 'archive'
        ]) }}">Arquivos</a>
      </li>
    </ul>
    <form
      method="post"
      action="{{ route('lesson.class.store', ['slug' => $course->slug]) }}"
      onsubmit="return submitLoad()"
    >
      {{ csrf_field() }}

      <input type="hidden" name="type" id="lesson-type" value="{{ $type }}"/>
      <input type="hidden" name="course_id" id="lesson-course-id" value="{{ $course->id }}"/>
      @if($section)
        <input type="hidden" name="section_id" id="lesson-section-id" value="{{ $section->id }}"/>
      @endif
      <div class="form-custom">
        <div class="form-group">
          <label for="lesson">Título</label>
          <input
            type="text"
            name="title"
            id="lesson-title"
            placeholder="Título da Aula..."
            required
          />          
        </div>
        <div class="form-group">
          <label for="lesson-description">Descrição</label>
          <textarea
            name="description"
            id="lesson-description"
            placeholder="Descrição da Aula..."
            required
          ></textarea>
        </div>
        @if($type == 'video')
          @include('utils.youtube-embed',[
            'value' => '',
            'id' => 'lesson-url',
            'label' => 'Vídeo de Apresentação (opcional)',
            'name' => 'url',
            'placeholder' => 'URL do Vídeo...'
          ])
        @elseif($type == 'article')
          <div class="form-group">
            <label for="lesson-content">Conteúdo</label>
            <textarea
              name="content"
              id="lesson-content"
              placeholder="Conteúdo da Aula..."
              class="custom-richtext"
              required
            ></textarea>
          </div>
        @elseif($type == 'archive')
          <button
            type="button"
            class="btn btn-primary"
            style="
              width: fit-content;
              min-width: 5rem !important;
              border-radius: 0.4rem;
              height: 2.4rem; 
              padding: 0;
            "
            onclick="haddleAddNewArchiveLink()"
          >@include('utils.icons.plus')</button>
          <div class="container-archives">
            <div class="wrapper-archive">
              <div class="content-archive">
                <div class="form-group">
                  <label>Link</label>
                  <input
                    type="text"
                    name="link_url[]"
                    placeholder="Link..."
                    required
                  />          
                </div>
                <div class="form-group">
                  <label>Descrição do Link</label>
                  <input
                    type="text"
                    name="link_description[]"
                    placeholder="Descrição do Link..."
                    required
                  />          
                </div>
              </div>
            </div>
          </div>
        @endif
        <button type="submit" class="btn btn-primary">Cadastrar</button>
      </div>
    </form>
  </div>
  @include('utils.loading')
@endsection
@section('script')
  <script>
    function handleRichText(){
      $('.custom-richtext').each(function(){
        CKEDITOR.replace($(this).attr('id'));
      });
    }
    function handleYoutubeEmbed(elem){
      const target = elem.next();
      let url = elem.val();
      if(url.indexOf('/embed/') === -1){
        url = url.replace('watch?v=','');
        url = url.replace('youtube.com/','youtube.com/embed/',url);
        url = url.replace('youtu.be/','youtube.com/embed/',url);

        let time = url.indexOf('&t=');
        if(time !== -1) url = url.substr(0,time);
      }
      target.val(url);
      target.parent().next().attr('src',url+"?autoplay=1&mute=1");
    }
    function haddleAddNewArchiveLink(){
      let html = `
        <div class="wrapper-archive">
          <div class="content-archive">
            <div class="form-group">
              <label>Link</label>
              <input
                type="text"
                name="link_url[]"
                placeholder="Link..."
                required
              />          
            </div>
            <div class="form-group">
              <label>Descrição do Link</label>
              <input
                type="text"
                name="link_description[]"
                placeholder="Descrição do Link..."
                required
              />          
            </div>
          </div>
          <button
            class="btn btn-secondary"
            onclick="$(this).parent().remove();"
          >@include('utils.icons.trash')</button>
        </div>
      `;
      $('.container-archives').append(html);
    }    
    $(function(){
      handleRichText();
    });
  </script>
@endsection
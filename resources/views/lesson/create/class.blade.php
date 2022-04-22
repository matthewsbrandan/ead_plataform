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
    <a href="{{ route('lesson.create',[
      'slug' => $course->slug
    ]) }}">
      <h1>
        @include('utils.icons.back') Aulas - <span style="color: #99a;">{{ $course->title }}</span> 
        {{ $section ? '| '.$section->title : '' }}
      </h1>
    </a>
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

      @if(isset($lesson))
        <input type="hidden" name="id" id="lesson-id" value="{{ $lesson->id }}"/>
      @endif
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
            value="{{ $lesson->title ?? '' }}"
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
          >{{ $lesson->description ?? '' }}</textarea>
        </div>
        @if($type == 'video')
          @include('utils.youtube-api',[
            'value' => $lesson->url ?? '',
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
            >{{ $lesson->content ?? '' }}</textarea>
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
          <?php
            $archives = [['link' => '', 'description' => '']];
            if(isset($lesson)){
              $archives = $lesson->getArchiveToArray();
            }
          ?>
          <div class="container-archives">
            <div class="wrapper-archive">
              <div class="content-archive">
                <div class="form-group">
                  <label>Link</label>
                  <input
                    type="text"
                    name="link_url[]"
                    placeholder="Link..."
                    value="{{ $archives[0]['link'] }}"
                    required
                  />          
                </div>
                <div class="form-group">
                  <label>Descrição do Link</label>
                  <input
                    type="text"
                    name="link_description[]"
                    placeholder="Descrição do Link..."
                    value="{{ $archives[0]['description'] }}"
                    required
                  />          
                </div>
              </div>
            </div>
            @if(count($archives) > 1)
              @foreach($archives as $index => $archive)
                @if($index > 0)
                  <div class="wrapper-archive">
                    <div class="content-archive">
                      <div class="form-group">
                        <label>Link</label>
                        <input
                          type="text"
                          name="link_url[]"
                          placeholder="Link..."
                          value="{{ $archive['link']}}"
                          required
                        />          
                      </div>
                      <div class="form-group">
                        <label>Descrição do Link</label>
                        <input
                          type="text"
                          name="link_description[]"
                          placeholder="Descrição do Link..."
                          value="{{ $archive['description']}}"
                          required
                        />          
                      </div>
                    </div>
                    <button
                      class="btn btn-secondary"
                      onclick="$(this).parent().remove();"
                    >@include('utils.icons.trash')</button>
                  </div>
                @endif
              @endforeach
            @endif
          </div>
        @endif
        @if(isset($lesson))  
          <button type="submit" class="btn btn-primary">Atualizar</button>
          <button
            type="button"
            onclick="confirmDelete('{{ route('lesson.class.delete', [
              'slug'=> $course->slug, 'id' => $lesson->id
            ]) }}')"
            class="btn btn-secondary"
          >Excluir</button>
        @else
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        @endif
      </div>
    </form>
  </div>
  @include('utils.loading')
@endsection
@section('script')
  <script>
    function confirmDelete(url){
      if(window.confirm('Tem certeza que deseja excluir essa aula?')) runLoad(url);
    }
    function handleRichText(){
      $('.custom-richtext').each(function(){
        CKEDITOR.replace($(this).attr('id'));
      });
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
@extends('layout.app')
@section('head')
  <title>Novo Curso | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/content-matters.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/course.css') }}">
  <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
  @php  $sidebarActive = 'course' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Novo Curso</h1>
    @include('course.partials.nav',['active' => 'mine'])
    <form
      method="POST"
      enctype="multipart/form-data"
      action="{{ route('course.mine.update') }}"
    >
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{ $course->id }}"/>
      <div class="container-grid">
        <div class="form-custom">
          <div class="form-group">
            <label for="course-title">Título</label>
            <input
              type="text"
              name="title"
              id="course-title"
              value="{{ $course->title }}"
              placeholder="Título do Curso..."
              required
            />
          </div>
          <div class="form-group">
            <label for="course-description">Descrição</label>
            <textarea
              name="description"
              id="course-description"
              placeholder="Descrição do Curso..."
              rows="15"
              required
            >{{ $course->description }}</textarea>
          </div>
        </div>
        <div>
          <label class="form-group form-control" style="
            margin-top: -.2rem;
            display: block;
          ">
            <span style="
              color: #99a;
              padding-bottom: .2rem;
              font-size: .7rem;
            ">Imagem de Capa</span>
            <img
              src="{{ asset($course->wallpaper) }}"
              class="image-mirror" alt="Imagem da Categoria"
              style="width: 100%; height: 24rem; object-fit: cover;"
            />
            <input
              type="file"
              accept="image/*"
              name="wallpaper"
              id="course-wallpaper"
              onchange="handleMirrorFileImg(event,$(this).prev())"
              style="display: none;"
            />
          </label>
        </div>
      </div>
      <strong style="
        margin: 1.2rem 0;
        display: block;
        font-size: 1.2rem;
      ">Selecione a Categoria/Matéria do Curso:</strong>
      <div class="scroll-matters">
        <button type="button" class="button-arrow arrow-left" onclick="handleScrollMatters()">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="m4.431 12.822 13 9A1 1 0 0 0 19 21V3a1 1 0 0 0-1.569-.823l-13 9a1.003 1.003 0 0 0 0 1.645z"></path></svg>
        </button>
        <div class="content-matters">
          <?php $category_default = $course->category; ?>
          @if($categoryOuthers)
            <div
              class="card-matter {{ $category_default->id == $categoryOuthers->id ? 'active':''}}"
              onclick="handleSelectCategory($categoryOuthers->id, '{{ $categoryOuthers->title }}', $(this))"
            >
              <strong style="font-size: 1rem;">{{$categoryOuthers->title}}</strong>
              <div class="matter">
                <img src="{{$categoryOuthers->wallpaper}}" alt="{{$categoryOuthers->title}}" style="
                  max-width: 12rem;
                  max-height: 20rem;
                  object-fit: cover;
                "/>
              </div>
              <small class="paragraph">{{ $categoryOuthers->description }}</small>
            </div>
          @endif
          @foreach($categories as $category)
            <div 
              class="card-matter {{ $category_default->id == $category->id ? 'active':''}}"
              onclick="handleSelectCategory({{ $category->id }}, '{{ $category->title }}', $(this))"
            >
              <strong style="font-size: 1rem;">{{$category->title}}</strong>
              <div class="matter">
                <img src="{{$category->wallpaper}}" alt="{{$category->title}}" style="
                  max-width: 12rem;
                  max-height: 20rem;
                  object-fit: cover;
                "/>
              </div>
              <small class="paragraph">{{ $category->description }}</small>
            </div>
          @endforeach
          <input
            type="hidden"
            name="category_id"
            id="course-category-id"
            value="{{ $category_default->id }}"
            required
          />
        </div>
        <button type="button" class="button-arrow arrow-right" onclick="handleScrollMatters(true)">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M5.536 21.886a1.004 1.004 0 0 0 1.033-.064l13-9a1 1 0 0 0 0-1.644l-13-9A1 1 0 0 0 5 3v18a1 1 0 0 0 .536.886z"></path></svg>
        </button>
      </div>
      <strong style="
        margin: 1.2rem 0 1rem;
        display: block;
        font-size: 1rem;
      ">
        Categoria/Matéria Selecionada:
        <span id="selected-category" style="color: #667;">{{ $category_default->title }}</span>
      </strong>
      <div class="form-custom" style="width: 100%;">
        <div class="form-group">
          <label for="course-about">Sobre (opcional)</label>
          <textarea
            name="about"
            id="course-about"
            placeholder="Sobre o Curso..."
            class="custom-richtext"
          >{{ $course->about }}</textarea>
        </div>
        <div class="container-grid">
          <div>
            @include('utils.youtube-embed',[
              'value' => $course->presentation_url,
              'id' => 'course-presentation-url',
              'label' => 'Vídeo de Apresentação (opcional)',
              'name' => 'presentation_url',
              'placeholder' => 'URL do Vídeo de Apresentação...',
              'required' => false
            ])
          </div>
          <div class="form-group">
            <label for="course-keywords">Palavras Chave (opcional)</label>
            <input
              type="text"
              name="keywords"
              id="course-keywords"
              value="{{ $course->keywords }}"
              placeholder="Palavras Chave..."
            />
          </div>
        </div>
      </div>
      <div style="
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin: 2rem 0;
        gap: 1rem;
      ">
        <button
          type="button"
          class="btn btn-secondary"
          style="min-width: 12rem;"
          onclick="confirmDelete()"
        >Excluir</button>
        <button
          type="submit"
          class="btn btn-primary"
          style="min-width: 12rem;"
        >Salvar Edição</button>
      </div>
    </form>
  </div>
@endsection
@section('script')
  <script>
    function handleSelectCategory(id, title, target){
      $('#course-category-id').val(id);
      $('#selected-category').html(title);
      $('.card-matter').removeClass('active');
      target.addClass('active');
    }
    function handleMirrorFileImg(event, targetImage){
      let files = event.target.files;
      let src = '';
      if(files){
        for(let index = 0; index < files.length; index++){
          var file = new FileReader();
          file.onload = function(e) {
            src = e.target.result;
            targetImage.attr('src', src ?? image_default);
          };       
          file.readAsDataURL(files[index]);
        }
      }
    }
    function handleScrollMatters(next = false){
      let jump = $('.content-matters').children().width();
      let currentPosition = $('.content-matters').scrollLeft();
      $('.content-matters').scrollLeft(next ? currentPosition + jump : currentPosition - jump);
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
      target.parent().next().attr('src',url);
    }
    function handleRichText(){
      $('.custom-richtext').each(function(){
        CKEDITOR.replace($(this).attr('id'));
      });
    }
    function confirmDelete(){
      if(window.confirm('Tem certeza que deseja excluir este curso? Todo o conteúdo cadastrado será perdido!')){
        window.location.href = "{{ route('course.mine.delete',['id' => $course->id]) }}";
      }
    }

    $(function(){
      handleRichText();
    });
  </script>
@endsection
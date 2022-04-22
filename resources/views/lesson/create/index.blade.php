@extends('layout.app')
@section('head')
  <title>Aulas | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/lesson.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/utils/loading.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
  @php  $sidebarActive = 'course' @endphp
@endsection
@section('content')
  <div class="container">
    <a href="{{ route('course.mine') }}">
      <h1>@include('utils.icons.back') Aulas - {{ $course->title }}</h1>
    </a>
    <div class="button-group-add">
      <button
        type="button"
        class="btn btn-primary"
        onclick="handleModalNewSection()"
        style="min-width: 12rem;"
      >Nova Seção</button>
      <button
        type="button"
        class="btn btn-secondary"
        style="min-width: 12rem;"
        onclick="runLoad('{{ route('lesson.class.create', ['slug' => $course->slug]) }}')"
      >Nova Aula</button>
    </div>
    <div id="content-lessons">
      @foreach($classes as $class)
        @if($class['type'] == 'section')
          @include('lesson.create.partials.section', ['class' => $class])
        @elseif($class['type'] == 'lesson')
          @include('lesson.create.partials.lesson', ['class' => $class])
        @endif
      @endforeach
    </div>
  </div>
  @include('lesson.create.modalNewSection')
  @include('utils.loading')
@endsection
@section('script')
  <script>
    function handleModalNewSection(section = null){
      let html = "";
      if(section) html = `
        <strong>${section.title}</strong>
        <input type="hidden" name="section_id" value="${section.id}"/>
      `;
      $('#father-section').html(html);
      $('#modalNewSection').show();
    }

    function confirmDelete(text, url){
      if(window.confirm(text)) runLoad(url);
    }
  </script>
@endsection
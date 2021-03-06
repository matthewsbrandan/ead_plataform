@extends('layout.app')
@section('head')
  <title>Categorias | {{ config('app.name') }}</title>
  @php  $sidebarActive = 'category' @endphp
@endsection
@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/content-matters.css') }}">
@endsection
@section('content')
  <div class="container">
    <div style="display: flex; gap: .4rem; align-items: center;">
      <h1>Categorias</h1>
      <a href="javascript: ;" onclick="handleNewCategory()" style="font-size: 0;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path></svg>
      </a>
    </div>
    <div class="content-matters">
      @foreach($categories as $category)
        <div onClick="handleEditCategory({{ $category->toJson() }})">
          <strong>{{$category->title}} <span class="badge">{{$category->num_courses}}</span></strong>
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
    </div>
  </div>
  @include('category.partials.modalNewCategory')
  @include('utils.loading')
@endsection
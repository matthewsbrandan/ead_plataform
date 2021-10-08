@extends('layout.app')
@section('head')
  <title>Categorias | {{ config('app.name') }}</title>
@endsection('head')
@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
  <style>
    .content-matters{
      display: flex;
      flex-wrap: wrap;
      gap: 4rem;
      margin: 1rem auto;
    }
    .content-matters > div{
      max-width: 17rem;
  
      display: flex;
      flex-direction: column;
      gap: .6rem;
    }
    .content-matters strong{
      font-size: 1.3rem;
      display: inline-flex;
      align-items: center;
      gap: .4rem;
    }
    .content-matters .matter{
      background: #dde;
  
      width: 280px;
      height: 280px;
  
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
@endsection('style')
@section('content')
  <div class="container">
    <div style="display: flex; gap: .4rem; align-items: center;">
      <h1>Categorias</h1>
      <a href="javascript: ;" onclick="$('#modalNewCategory').show();" style="font-size: 0;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path></svg>
      </a>
    </div>
    <div class="content-matters">
      @foreach($categories as $category)
        <div>
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
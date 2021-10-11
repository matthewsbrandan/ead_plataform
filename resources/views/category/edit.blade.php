@extends('layout.app')
@section('head')
  <title>Editar Categoria | {{ config('app.name') }}</title>
  @php  $sidebarActive = 'category' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>{{ $category->title }}</h1>
  </div>
@endsection
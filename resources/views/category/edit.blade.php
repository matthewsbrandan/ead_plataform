@extends('layout.app')
@section('head')
  <title>Editar Categoria | {{ config('app.name') }}</title>
@endsection('head')
@section('content')
  <div class="container">
    <h1>{{ $category->title }}</h1>
  </div>
@endsection
@extends('layout.app')
@section('head')
  <title>Explorar | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/explorer.css') }}">
  @php  $sidebarActive = 'explorer' @endphp
@endsection
@section('content')
  @include('explorer.partials.content')
  @include('utils.loading')
@endsection
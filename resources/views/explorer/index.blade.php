@extends('layout.app')
@section('head')
  <title>Explorar | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/explorer.css') }}">
  @php  $sidebarActive = 'explorer' @endphp
@endsection
@section('content')
  @include('explorer.partials.content')
  @include('utils.loading')
@endsection
@section('script')
  <script>
    function handleToggleFilter(){
      $('#container-filters').toggle('slow');
      $('#container-filters input').focus();
    }
    function handleFilter(){
      let search = $('#search-input').val().toLowerCase();
      $('.course').each(function(){
        let title = $(this).attr('data-title').toLowerCase();
        if(title.indexOf(search) !== -1) $(this).show('slow');
        else $(this).hide('slow');
      });
    }
  </script>
@endsection
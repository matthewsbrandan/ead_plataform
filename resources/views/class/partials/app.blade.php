<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  @yield('head')
  
  <link rel="shortcut icon" href="{{ asset('assets/icons/homepage.svg') }}" type="image/svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/class/app.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/class/sidebar.css') }}">
  <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
  @yield('style')
</head>
<body>
  <main id="root">
    @include('class.partials.sidebar')
    <div id="main">
      @yield('content')
    </div>
    @include('utils.modalMessage')
    @include('utils.loading')
  </main>
  <script>
    $(function(){
      @if(session()->has('message'))
        showMessage("{!! session()->get('message') !!}");
      @endif
    })
  </script>
  @yield('script')
</body>
</html>
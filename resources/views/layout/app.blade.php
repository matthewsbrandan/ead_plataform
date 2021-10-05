<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  @yield('head')
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/layout/sidebar.css') }}">
  <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <style>
    #main{
      margin-left: 5rem;
    }
    #root.header-expanded #main{
      margin-left: 15rem;
    }
    #main{
      padding: 1.4rem;
    }
  </style>
</head>
<body>
  <main id="root">
    @include('layout.sidebar')
    <div id="main">
      @yield('content')
    </div>
    @include('utils.search-box')
    @include('utils.modalMessage')
  </main>
  <script>
    $(function(){
      const paths = window.location.pathname.split('/');
      paths.shift();
      if(paths.length > 0){
        $(`#sidebar-${paths[0]}`).addClass('active');
        if(`#sidebar-${paths[0]}` === '#sidebar-pagina'){
          $('#sidebar-pagina > span').click();
        }
        let breadcrumbs = paths.map(path => `<li>${path}</li>`).join('');
        $('#navbar .breadcrumbs').html(breadcrumbs);
      }
      @if(session()->has('message'))
        showMessage("{!! session()->get('message') !!}");
      @endif
    })
  </script>
  @yield('script')
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="shortcut icon" href="{{ asset('assets/icons/homepage.svg') }}" type="image/svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/layout/app.css') }}">
  <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Explorar | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/explorer.css') }}">
  <style>
    .container{
      padding: 1rem 1.6rem 2rem;
    }
  </style>
</head>
<body>
  @include('explorer.partials.content')
</body>
</html>
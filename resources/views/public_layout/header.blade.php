<!-- 
  OPTIONAL PARAMS: ['header_options' => [['name' => 'option_name', 'href' => '#']]]
 -->
<header class="header-main">
  <div class="container">
    <a href="{{ route('index') }}">
      <div class="logo">
        <svg preserveAspectRatio="xMidYMid meet" id="comp-k8x5jfyesvgcontent" data-bbox="36.8 60.7 126.3 75" viewBox="36.8 60.7 126.3 75" height="35" width="44" xmlns="http://www.w3.org/2000/svg" data-type="color" role="img" aria-labelledby="comp-k8x5jfye-svgtitle"><title id="comp-k8x5jfye-svgtitle">Homepage</title><g><path d="M144.1 124.9V60.7H55.9v64.1l-19.1 6.6v4.3h126.3v-4.3l-19-6.5zm-6-.1H61.9V67.4h76.3v57.4z"fill="#8f98ff" data-color="1"></path><path fill="#192a88" d="M138.2 67.4v57.5H61.9V67.4h76.3z" data-color="2"></path></g></svg>
        <span>{{ config('app.name') }}</span>
      </div>
    </a>
    <button type="button" class="btn-toggle-navbar" onclick="$(this).next().toggle('slow')">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path></svg>
    </button>
    <nav class="navbar">
      <ul>
        @if(isset($header_options) && is_array($header_options))
          @foreach($header_options as $option)
            <li><a href="{{ $option['href'] }}">{{ $option['name'] }}</a></li>
          @endforeach
        @else
          <li><a href="#matters">Matérias</a></li>
          <li><a href="#about">Sobre</a></li>
          <li><a href="#contact">Entre em Contato</a></li>
        @endif
      </ul>
    </nav>
  </div>
</header>
<footer id="contact">
  <div class="container">
    <div class="logo">
      <svg preserveAspectRatio="xMidYMid meet" id="comp-k8x5jfyesvgcontent" data-bbox="36.8 60.7 126.3 75"viewBox="36.8 60.7 126.3 75" height="35" width="44" xmlns="http://www.w3.org/2000/svg" data-type="color" role="img" aria-labelledby="comp-k8x5jfye-svgtitle"><title id="comp-k8x5jfye-svgtitle">Homepage</title><g><path d="M144.1 124.9V60.7H55.9v64.1l-19.1 6.6v4.3h126.3v-4.3l-19-6.5zm-6-.1H61.9V67.4h76.3v57.4z" fill="#8f98ff" data-color="1"></path><path fill="#192a88" d="M138.2 67.4v57.5H61.9V67.4h76.3z" data-color="2"></path></g></svg>
      <span>
        {{ config('app.name') }}
        @if(config('app.beta')) <span class="badge" style="
          background: #223;
          color: #eef;
          border-radius: .4rem;
          font-size: .7rem;
          vertical-align: 3px;
        ">BETA</span> @endif
      </span>
    </div>
    <div class="wrapper">
      <ul>
        <li><a href="#matters">Matérias</a></li>
        <li><a href="#about">Sobre</a></li>
        <li><a href="#contact">Entre em Contato</a></li>
      </ul>
      <ul>
        <li>contato@codewriters.space</li>
        <li>(19) 9 9544-6606</li>
      </ul>
      <em>© {{ \Carbon\Carbon::now()->format('Y') }} - PI Univesp.</em>
    </div>
  </div>
</footer>
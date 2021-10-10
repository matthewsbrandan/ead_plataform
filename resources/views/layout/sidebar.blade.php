<aside id="sidebar">
  <a href="javascript:;" onclick="toggleExpandSidebar($(this))">
    <div class="logo">
      <svg preserveAspectRatio="xMidYMid meet" id="comp-k8x5jfyesvgcontent" data-bbox="36.8 60.7 126.3 75" viewBox="36.8 60.7 126.3 75" height="35" width="44" xmlns="http://www.w3.org/2000/svg" data-type="color" role="img" aria-labelledby="comp-k8x5jfye-svgtitle"><title id="comp-k8x5jfye-svgtitle">Homepage</title><g><path d="M144.1 124.9V60.7H55.9v64.1l-19.1 6.6v4.3h126.3v-4.3l-19-6.5zm-6-.1H61.9V67.4h76.3v57.4z"fill="#8f98ff" data-color="1"></path><path fill="#192a88" d="M138.2 67.4v57.5H61.9V67.4h76.3z" data-color="2"></path></g></svg>
      <span class="show-if-expanded">{{ config('app.name') }}</span>
    </div>
  </a>
  <ul id="list-routes">
    <li id="sidebar-home">
      <a href="{{ route('home') }}">
        <svg title="Home" alt="Home" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="m21.743 12.331-9-10c-.379-.422-1.107-.422-1.486 0l-9 10a.998.998 0 0 0-.17 1.076c.16.361.518.593.913.593h2v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-4h4v4a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-7h2a.998.998 0 0 0 .743-1.669z"></path></svg>
        <span class="show-if-expanded">Home</span>
      </a>
    </li>
    <li id="sidebar-meus-cursos">
      <a href="{{ route('course.index') }}">
        <svg title="Meus Cursos" alt="Meus Cursos" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M20 3H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zm-1 4v2h-5V7h5zm-5 4h5v2h-5v-2zM4 19V5h7v14H4z"></path></svg>
        <span class="show-if-expanded">Meus Cursos</span>
      </a>
    </li>
    <li id="sidebar-chats">
      <a href="{{ route('chat.index') }}">
        <svg title="Chats" alt="Chats" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M12.077 3C7.149 3 3 6.96 3 11.843V21l9.075-.01c4.928 0 8.925-4.11 8.925-8.993C21 7.113 17 3 12.077 3zm3.92 12.859a5.568 5.568 0 0 1-6.102 1.043l-3.595.805 1.001-3.192a5.435 5.435 0 0 1 .11-5.415 5.55 5.55 0 0 1 4.753-2.678v.001h.006a5.533 5.533 0 0 1 5.131 3.438 5.442 5.442 0 0 1-1.304 5.998z"></path></svg>
        <span class="show-if-expanded">Chats</span>
      </a>
    </li>
    @if(auth()->user()->type === 'admin')
      <li id="sidebar-categorias">
        <a href="{{ route('category.index') }}">
          <svg title="Categorias" alt="Categorias" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm10 10h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zM17 3c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zM7 13c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4z"></path></svg>
          <span class="show-if-expanded">Categorias</span>
        </a>
      </li>
    @endif
    <li>
      <a href="javascript: showSearchBox();">
        <svg title="Pesquisar" alt="Pesquisar" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path></svg>
        <span class="show-if-expanded">Pesquisar</span>
      </a>
    </li>
  </ul>
  <div class="content-avatar">
    <img
      src="{{ auth()->user()->thumbnail ?? asset('assets/images/user-default.jpeg') }}"
      onclick="$(this).next().next().toggle('slow')"
    />
    <span class="show-if-expanded text-ellipsis" style="
      vertical-align: 11px;
      padding: .3rem;
    " onclick="$(this).next().toggle('slow')">{{ auth()->user()->name }}</span>
    <div class="dropdown">
      <ul>
        <li><a href="{{ route('user.notification') }}">Notificações</a></li>
        <li><a href="{{ route('user.profile.index') }}">Perfil</a></li>
        <li><a href="{{ route('logout') }}">Sair</a></li>
      </ul>
    </div>
  </div>
  <a id="close-sidebar" onclick="$('#sidebar').removeClass('expanded');">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
      <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
    </svg>
  </a>
</aside>
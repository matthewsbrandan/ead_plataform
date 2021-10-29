<aside id="sidebar">
  <div class="wrapper">
    <a href="#">@include('utils.icons.logo')</a>
    <ul class="sidebar-list">
      <li class="{{ $sidebarActive == 'details' ? 'active' : '' }}">@include('utils.icons.details')</li>
      <li class="{{ $sidebarActive == 'book' ? 'active' : '' }}">@include('utils.icons.book')</li>
      <li class="{{ $sidebarActive == 'chat' ? 'active' : '' }}">@include('utils.icons.chat')</li>
      <li class="{{ $sidebarActive == 'plus' ? 'active' : '' }}">@include('utils.icons.plus',['svgFill' => '#445'])</li>
      <li>@include('utils.icons.search')</li>
    </ul>
    <a href="#">@include('utils.icons.back')</a>
  </div>
</aside>
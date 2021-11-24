<aside id="sidebar">
  <div class="wrapper">
    <a href="{{ route('index') }}">@include('utils.icons.logo')</a>
    <ul class="sidebar-list">
      <li
        class="{{ $sidebarActive == 'details' ? 'active' : '' }}"
        onclick="runLoad('{{ route('class.index',['slug' => $course->slug]) }}')"
      >@include('utils.icons.details')</li>
      <li
        class="{{ $sidebarActive == 'book' ? 'active' : '' }}"
        onclick="runLoad('{{ route('class.show',['slug' => $course->slug]) }}')"
      >@include('utils.icons.book')</li>
      <li
        class="{{ $sidebarActive == 'chat' ? 'active' : '' }}"
        
        onclick="runLoad('{{ route('chat.course',['slug' => $course->slug, 'user_id' => auth()->user()->id]) }}')"
      >@include('utils.icons.chat')</li>
      <li
        class="{{ $sidebarActive == 'plus' ? 'active' : '' }}"
        onclick="runLoad('{{ route('class.outhers',['slug' => $course->slug]) }}')"
      >@include('utils.icons.plus',['svgFill' => '#445'])</li>
      <!-- <li>@include('utils.icons.search')</li> -->
    </ul>
    <a href="{{ route('course.index') }}">@include('utils.icons.back')</a>
  </div>
</aside>
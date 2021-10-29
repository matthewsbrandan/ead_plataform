<li
  class="lesson-item {{ $class['data']->id == $currentLesson->id ? 'active':'' }}"
  onclick="handleSelectLesson($(this),{{ $class['data']->toJson() }},'{{ $class['data']->formatDuration() }}')">
  <div>
    @include('utils.icons.'.$class['data']->type)
    <span>{{ $class['data']->title }}</span>
  </div>
  <time>{{ $class['data']->formatDuration() }}</time>
</li>
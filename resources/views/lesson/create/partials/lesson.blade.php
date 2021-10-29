<div>
  @include('utils.icons.'.$class['data']->type)
  <span>{{ $class['data']->title }}</span>
</div>
<time>{{ $class['data']->formatDuration() }}</time>
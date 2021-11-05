<div onclick="runLoad('{{ route('lesson.class.edit', ['slug' => $course->slug, 'id' => $class['data']->id ]) }}')">
  @include('utils.icons.'.$class['data']->type)
  <span>{{ $class['data']->title }}</span>
</div>
<time>{{ $class['data']->formatDuration() }}</time>
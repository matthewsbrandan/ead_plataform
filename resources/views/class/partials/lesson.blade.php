<?php
  $lessonStudentJSON = $class['data']->student(true);
  $isViewed = false;
  if($lessonStudentJSON){
    $isViewed = $class['data']->student()->viewed == 1;
  }

?>
<li
  class="lesson-item {{ $class['data']->id == $currentLesson->id ? 'active':'' }} {{ $isViewed ? 'viewed':'' }}"
  onclick="handleSelectLesson(
    $(this),
    {{ $class['data']->toJson() }},
    '{{ $class['data']->formatDuration() }}',
    {{ $lessonStudentJSON }}
  )"
  id="lesson-{{ $class['data']->real_index }}"
>
  <div>
    @include('utils.icons.'.$class['data']->type)
    <span>{{ $class['data']->title }}</span>
  </div>
  <time>{{ $class['data']->formatDuration() }}</time>
</li>
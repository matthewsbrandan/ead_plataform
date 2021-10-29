<li class="section-item">
  <div class="header">
    <strong style="color: #000;">{{ $class['data']->title }}</strong>
  </div>
  <ul class="lesson-list">
    @foreach($class['data']->classes as $subClass)
      @if($subClass['type'] == 'section')
        @include('class.partials.section', ['class' => $subClass])
      @elseif($subClass['type'] == 'lesson')
        @include('class.partials.lesson', ['class' => $subClass])
      @endif
    @endforeach
  </ul>
</li>
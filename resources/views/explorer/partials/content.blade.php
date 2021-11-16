<div class="container">
  <h1>Explorar Cursos</h1>
  <div class="content-courses">
    @foreach($courses as $course)
      <div class="course">
        <img src="{{ $course->wallpaper }}" alt="{{ $course->title }}"/>
        <div class="course-info">
          <div class="title">
            <strong>{{ $course->title }}</strong>
            @if($course->rating)
                <small>{{ $course->rating }} <span style="color: #fb1;">&#9733;</span></small>
              @endif
          </div>
          <p>{{ $course->description }}</p>
          <div class="badge"> {{ $course->category->title }} </div>
          <div class="actions">
            <div>
              @if($course->formatDuration())
                <span>Duração {{ $course->formatDuration() }}</span>
              @endif
              @if($course->published_at)
                <span>Publicado em {{ $course->published_at->format('m/Y') }}</span>
              @endif
            </div>
          </div>
        </div>
        <a class="btn-primary" href="{{ route('class.index',['slug' => $course->slug]) }}">Ver</a>
      </div>
    @endforeach
  </div>
</div>
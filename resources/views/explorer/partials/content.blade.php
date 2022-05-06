<div class="container">
  <div style="
    display: flex;
    align-items: center;
    justify-content: space-between;
  ">
    <h1>Explorar Cursos</h1>
    <button
      type="button"
      class="btn-clean btn-svg"
      onclick="handleToggleFilter()"
    >@include('utils.icons.search')</button>
  </div>
  <div
    class="form-custom"
    id="container-filters"
    style="
      padding-top: 1rem;
      width: 100%;
      display: none;
    "
  >
    <div class="form-group">
      <input
        type="text"
        name="search"
        id="search-input"
        placeholder="Pesquise o nome do Curso..."
        onkeyup="handleFilter()"
        required
      />
    </div>
  </div>
  <div class="content-courses">
    @foreach($courses as $course)
      <div
        class="course"
        data-title="{{ $course->title }}"
      >
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
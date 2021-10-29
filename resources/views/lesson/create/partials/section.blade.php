<div class="section">
  <div class="header">
    <strong style="color: #000;">{{ $class['data']->title }}</strong>
    <div class="button-group">
      <button
        type="button"
        class="btn btn-primary"
        onclick="handleModalNewSection({ 
          id: {{ $class['data']->id }},
          title: '{{ $class['data']->title }}'
        })"
      >
        @include('utils.icons.plus')
      </button>
      <button
        type="button"
        class="btn btn-secondary"
        onclick="runLoad('{{ route('lesson.class.create', [
          'slug' => $course->slug, 'section_id' => $class['data']->id
        ]) }}')"
      >
        @include('utils.icons.plus',['svgFill' => '#445'])
      </button>
      <button
        type="button"
        class="btn btn-secondary"
        onclick="confirmDelete(
          'Tem certeza que deseja excluir essa seção?',
          '{{ route('section.delete',['id' => $class['data']->id]) }}'
        );"
      >
        @include('utils.icons.trash')
      </button>
    </div>
  </div>
  <ol class="content">
    @foreach($class['data']->classes as $subClass)
      <li>
        @if($subClass['type'] == 'section')
          @include('lesson.create.partials.section', ['class' => $subClass])
        @elseif($subClass['type'] == 'lesson')
          @include('lesson.create.partials.lesson', ['class' => $subClass])
        @endif
      </li>
    @endforeach
  </ol>
</div>
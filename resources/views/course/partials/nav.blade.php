<ul class="navbar">
  <li class="{{ $active == 'index' ? 'active':'' }}"><a href="{{ route('course.index') }}">Cursando</a></li>
  @if(auth()->user()->isTeacher())
    <li class="{{ $active == 'mine' ? 'active':'' }}"><a href="{{ route('course.mine') }}">Meus Cursos</a></li>
    <li class="{{ $active == 'create' ? 'active':'' }}"><a href="{{ route('course.create') }}">Novo Curso</a></li>
  @endif
</ul>
@extends('class.partials.app')
@section('head')
  <title>{{ $course->title }} | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/class/about.css') }}">
  @php  $sidebarActive = 'details' @endphp
@endsection
@section('content')
  <div class="container">
    <h1 class="course-title">{{ $course->title }}</h1>
    
    <div class="wrapper">
      <div class="content">
        <div class="table-responsive">
          <table id="table-course-data">
            <tbody>
              <?php
                $trs = [
                  (object)['th' => 'Avaliações', 'td' => $course->raiting ?? '-'],
                  (object)['th' => 'Núm. Aulas', 'td' => $course->num_classes],
                  (object)['th' => 'Núm. Alunos', 'td' => $course->num_students],
                  (object)['th' => 'Duração do Curso', 'td' => $course->durationInMinutes()]
                ];
                foreach($trs as $tr){
              ?>
                <tr>
                  <th>{{ $tr->th }}</th>
                  <td>{{ $tr->td }}</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <hr style="
          border-color: #eef6;
          margin: 2rem 0 1.4rem;
        "/>
        {!! $course->about !!}
      </div>
      <aside class="aside">
        <div class="content">
          @if($course->presentation_url)
            <iframe
              id="embed"
              style="width: 100%; min-height: 10rem; margin-top: .4rem; border: 1px solid #eef;"
              src="{{ $course->presentation_url }}"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>
          @else <h3>{{ $course->title }}</h3> @endif
          <p class="description">{{ $course->description }}</p>
          @if($course->students->count() > 0)
            <div class="progress">
              <div class="progress-line" style="width: {{ $course->students[0]->progress }}%; "></div>
            </div>
          @else
            <a href="{{ route('class.subscribe',['slug' => $course->slug]) }}" class="btn-primary btn-block">Matricule-se</a>
          @endif
        </div>
      </aside>
    </div>
  </div>
@endsection
@extends('layout.app')
@section('head')
  <title>Perfil | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/profile.css') }}">
  @php  $sidebarActive = 'profile' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Perfil</h1>
    <p style="color: #99a;">Detalhes do seu perfil</p>
    <div class="content-profile">
      <form
        method="POST"
        action="{{ route('user.profile.update') }}"
        onsubmit="return submitLoad()"
        enctype="multipart/form-data"
      >
        <div class="content-thumbnail">
          <img
            src="{{ auth()->user()->thumbnail ?? asset('assets/images/user-default.jpeg') }}"
            alt="{{ auth()->user()->name }}"
            onclick="$(this).next().click();"
          />
          <input
            type="file"
            name="thumbnail"
            accept="image/*"
            onchange="handleMirrorFileImg(event,$(this).prev())"
            style="display: none;"
          />
          <div class="user-type">
            <a
              href="{{ route('user.profile.change_type',['type' => 'student']) }}"
              onclick="$(this).addClass('active'); $(this).next().removeClass('active');"
              class="user-type-left {{ auth()->user()->type == 'student' ? 'active':'' }}"
            >Aluno</a>
            <a
              href="{{ route('user.profile.change_type',['type' => 'teacher']) }}"
              onclick="$(this).addClass('active'); $(this).prev().removeClass('active');"
              class="user-type-right {{ auth()->user()->type == 'teacher' ? 'active':'' }}"
            >Professor</a>
          </div>
        </div>
        <div class="form-custom">
          {{ csrf_field() }}
          <div class="form-group">
            <label>Nome:</label>
            <input
              type="text"
              name="name"
              placeholder="Digite seu Nome..."
              value="{{ auth()->user()->name }}"
              autofocus
              required
            />
          </div>
          <div class="form-group">
            <label>Email: (não editável)</label>
            <input
              type="email"
              placeholder="Digite seu Email..."
              value="{{ auth()->user()->email }}"
              readonly
              required
            />
          </div>
          <div class="button-group">
            <button type="submit" class="btn-primary">
              Atualizar
            </button>
            <button
              type="button"
              class="btn-secondary"
              onclick="$('#form-password').toggle('slow')"
            >
              Alterar Senha
            </button>
          </div>
        </div>
      </form>
      <form
        method="POST"
        action="{{ route('user.profile.change_password') }}"
        onsubmit="return submitLoad()"
        class="form-custom"
        id="form-password"
        style="display: none"
      >
        {{ csrf_field() }}
        <div class="form-group {{ session()->has('invalid-password') ? 'have-error':''}}">
          <label>Senha Atual:</label>
          <input
            type="password"
            name="password"
            placeholder="Digite sua Senha Atual..."
            required
          />
          <span class="error-message">Senha inválida</span>
        </div>
        <div class="form-group">
          <label>Nova Senha:</label>
          <input
            type="password"
            name="new_password"
            placeholder="Digite sua Nova Senha..."
            required
          />
        </div>
        <div class="button-group">
          <button type="submit" class="btn-primary" style="align-self: flex-end;">
            Alterar Senha
          </button>
        </div>
      </form>
    </div>
  </div>
  @include('utils.loading')
@endsection
@section('script')
  <script>
    function handleMirrorFileImg(event, targetImage){
      let files = event.target.files;
      let src = '';
      if(files){
        for(let index = 0; index < files.length; index++){
          var file = new FileReader();
          file.onload = function(e) {
            src = e.target.result;
            targetImage.attr('src', src ?? image_default);
          };       
          file.readAsDataURL(files[index]);
        }
      }
    }
    $(function(){
      @if(session()->has('invalid-password'))
        $('#form-password').toggle('slow')
        $('#form-password input[name="password"]').focus();
      @endif
    });
  </script>
@endsection
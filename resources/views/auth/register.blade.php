<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro | {{ config('app.name') }}</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/public_layout/header.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/public_layout/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/utils/loading.css') }}">
  <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <style>
    .btn-check{
      position: absolute;
      font-size: 0;
      background: transparent;
      border-radius: .2rem;
      transition: .6s;
    }
    .mirror-user-type{
      transition: .6s;
    }
  </style>
</head>
<body>
  @include('public_layout.header',['header_options' => [
    ['name' => 'Logar', 'href' => route('login')],
    ['name' => 'Voltar', 'href' => route('index')]
  ]])
  <main>
    <form method="POST" action="{{ route('user.store') }}" onSubmit="return submitLoad();">
      {{ csrf_field() }}
      <h1>Cadastre-se</h1>
      <div class="form-group">
        <input
          type="text"
          name="name"
          placeholder="Digite seu Nome..."
          autofocus
          required
        />
      </div>
      <div class="form-group {{ session()->has('register-error-type') &&  session()->get('register-error-type') == 'email' ? 'have-error':''}}">
        <input
          type="email"
          name="email"
          placeholder="Digite seu Email..."
          required
        />
        <span class="error-message">Email já está em uso</span>
      </div>
      <div class="form-group" style="position: relative;">
        <input
          type="password"
          name="password"
          placeholder="Digite sua Senha..."
          required
        />
        <button type="button" class="btn-check" style="right: .3rem; height: 100%;" onclick="togglePasswordType($(this))">
          <svg style="fill: #445;transform: ;msFilter:;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
        </button>
        <button type="button" class="btn-check" style="right: .3rem; height: 100%; display: none;" onclick="togglePasswordType($(this), false)">
          <svg style="fill: #445;transform: ;msFilter:;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 19c.946 0 1.81-.103 2.598-.281l-1.757-1.757c-.273.021-.55.038-.841.038-5.351 0-7.424-3.846-7.926-5a8.642 8.642 0 0 1 1.508-2.297L4.184 8.305c-1.538 1.667-2.121 3.346-2.132 3.379a.994.994 0 0 0 0 .633C2.073 12.383 4.367 19 12 19zm0-14c-1.837 0-3.346.396-4.604.981L3.707 2.293 2.293 3.707l18 18 1.414-1.414-3.319-3.319c2.614-1.951 3.547-4.615 3.561-4.657a.994.994 0 0 0 0-.633C21.927 11.617 19.633 5 12 5zm4.972 10.558-2.28-2.28c.19-.39.308-.819.308-1.278 0-1.641-1.359-3-3-3-.459 0-.888.118-1.277.309L8.915 7.501A9.26 9.26 0 0 1 12 7c5.351 0 7.424 3.846 7.926 5-.302.692-1.166 2.342-2.954 3.558z"></path></svg>
        </button>
      </div>
      <div class="form-group">
        <div style="position: relative;">
          <button 
            type="button"
            class="btn-check"
            onclick="toggleUserType($(this), true)"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M8 9c-1.628 0-3 1.372-3 3s1.372 3 3 3 3-1.372 3-3-1.372-3-3-3z"></path><path d="M16 6H8c-3.3 0-5.989 2.689-6 6v.016A6.01 6.01 0 0 0 8 18h8a6.01 6.01 0 0 0 6-5.994V12c-.009-3.309-2.699-6-6-6zm0 10H8a4.006 4.006 0 0 1-4-3.99C4.004 9.799 5.798 8 8 8h8c2.202 0 3.996 1.799 4 4.006A4.007 4.007 0 0 1 16 16zm4-3.984.443-.004.557.004h-1z"></path></svg>
          </button>
          <button
            type="button"
            class="btn-check"
            style="display: none;"
            onclick="toggleUserType($(this))"
            >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M16 9c-1.628 0-3 1.372-3 3s1.372 3 3 3 3-1.372 3-3-1.372-3-3-3z"></path><path d="M16 6H8c-3.296 0-5.982 2.682-6 5.986v.042A6.01 6.01 0 0 0 8 18h8c3.309 0 6-2.691 6-6s-2.691-6-6-6zm0 10H8a4.006 4.006 0 0 1-4-3.99C4.004 9.799 5.798 8 8 8h8c2.206 0 4 1.794 4 4s-1.794 4-4 4z"></path></svg>
          </button>
        </div>
        <span style="display: block; margin-left: 1.8rem;" class="mirror-user-type">Aluno</span>
        <input type="hidden" name="type" id="user-type" value="student"/>
      </div>
      <button type="submit" class="btn-primary">
        Cadastrar
      </button>
      <div class="link-group"><a href="{{ route('login') }}">Já sou cadastrado</a></div>
    </form>
  </main>
  @include('public_layout.footer')
  @include('utils.loading')
  @include('utils.modalMessage')
  <script>
    $(function(){
      @if(session()->has('message'))
        showMessage("{{ session()->get('message') }}");
      @endif
    });
    function toggleUserType(elem, isTeacher = false){
      if(isTeacher){
        elem.hide().next().show();
        $('.mirror-user-type').html('Professor');
        $('#user-type').val('teacher');
      }else{
        elem.hide().prev().show();
        $('.mirror-user-type').html('Aluno');
        $('#user-type').val('student');
      }
    }
    function togglePasswordType(elem, show = true){
      if(show){
        elem.hide().prev().attr('type', 'text');
        elem.next().show();
      }else{
        elem.hide().prev().prev().attr('type', 'password');
        elem.prev().show();
      }
    }
  </script>
</body>
</html>
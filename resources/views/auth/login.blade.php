<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | {{ config('app.name') }}</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/public_layout/header.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/public_layout/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/utils/loading.css') }}">
  <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
</head>
<body>
  @include('public_layout.header',['header_options' => [
    ['name' => 'Cadastre-se', 'href' => route('register')],
    ['name' => 'Voltar', 'href' => route('index')]
  ]])
  <main>
    <form method="POST" action="{{ route('login') }}" onSubmit="return submitLoad();">
      {{ csrf_field() }}
      <h1>Login</h1>
      <div class="form-group {{ session()->has('auth-error-type') &&  session()->get('auth-error-type') == 'email' ? 'have-error':''}}">
        <input
          type="email"
          name="email"
          placeholder="Digite seu Email..."
          autofocus
          required
        />
        <span class="error-message">Email não encontrado</span>
      </div>
      <div class="form-group {{ session()->has('auth-error-type') &&  session()->get('auth-error-type') == 'password' ? 'have-error':''}}">
        <input
          type="password"
          name="password"
          placeholder="Digite sua Senha..."
          required
        />
        <span class="error-message">Senha inválida</span>
      </div>
      <button type="submit" class="btn-primary">
        Entrar
      </button>
      <div class="link-group">
        <a href="{{ route('register') }}">Cadastre-se</a>
        <a href="{{ route('forgot_password') }}">Esqueci a senha</a>
      </div>
    </form>
  </main>
  @include('public_layout.footer')
  @include('utils.loading')
</body>
</html>
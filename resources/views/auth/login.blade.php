<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | {{ config('app.name') }}</title>

  <link rel="shortcut icon" href="{{ asset('assets/icons/homepage.svg') }}" type="image/svg">
  
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
      @isset($goback)
        <input type="hidden" name="redirect_to" value="{{ $goback }}"/>
      @endisset
      <div style="
        display: flex;
        align-items: center;
        justify-content: space-between;
      ">
        <h1>Login</h1>
        <button
          class="btn-clean"
          type="button"
          onclick="help()"
        >@include('utils.icons.help')</button>
      </div>
      <div class="form-group {{ session()->has('auth-error-type') &&  session()->get('auth-error-type') == 'email' ? 'have-error':''}}">
        <input
          type="email"
          name="email"
          placeholder="Digite seu Email..."
          autofocus
          required
        />
        <span class="error-message">Email n??o encontrado</span>
      </div>
      <div class="form-group {{ session()->has('auth-error-type') &&  session()->get('auth-error-type') == 'password' ? 'have-error':''}}">
        <input
          type="password"
          name="password"
          placeholder="Digite sua Senha..."
          required
        />
        <span class="error-message">Senha inv??lida</span>
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
  @include('utils.modalMessage')
  @include('utils.loading')
  <script>
    $(function(){
      @if(session()->has('message'))
        showMessage("{{ session()->get('message') }}");
      @endif
    });
    function help(){
      showMessage(`
        <article style="text-align: left;">
          <div style="margin-bottom: .8rem;">
            <strong>P??gina:</strong> Login.
          </div>
          <div style="margin-bottom: .8rem;">
            <strong>Descri????o:</strong> Nesta p??gina voc?? faz o login para acessar a plataforma.
          </div>
          <div style="margin-bottom: .8rem;">
            <strong>Instru????es:</strong>
            <p style="margin: .2rem 0 .6rem;">
              - Se voc?? j?? ?? cadastrado, basta preencher seu email, senha e depois clicar no bot??o <em>"Entrar"</em> para acessar a plataforma.
            </p>
            <p style="margin-bottom: .6rem;">
              - Se voc?? esqueceu sua senha basta clicar no link <em>"Esqueci a senha"</em> abaixo do bot??o <em>"Entrar"</em>.
            </p>
            <p style="margin-bottom: .6rem;">
              - Caso voc?? ainda n??o tenha cadastro, abaixo do bot??o <em>"Entrar"</em> h?? um link para a p??gina de cadastro(<em>"Cadastre-se"</em>).
            </p>
          </div>
        </article>
      `, 'Auto - Ajuda');
    }
  </script>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name') }}</title>

  <link rel="shortcut icon" href="{{ asset('assets/icons/homepage.svg') }}" type="image/svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display:wght@100;200;300;400;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/public_layout/header.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/public_layout/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/beta.css') }}">
</head>

<body>
  @include('public_layout.header')
  <main>
    <img class="wallpaper" src="https://guiadoestudante.abril.com.br/wp-content/uploads/sites/4/2019/10/organize-seus-estudos-com-a-tc3a9cnica-do-quadro-kanban.jpg"/>
    <div class="overlay"></div>
    <div class="container">
      <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
        <div class="card card-50">
          <strong>Bem vindo a Plataforma</strong>
          <p>O EAD Plataform é uma plataforma de ensino a distância, com os mais variados cursos, e com a possibilidade de você criar os seus cursos, tudo de forma gratuita.</p>
        </div>
        <div class="card card-50">
          <strong>O que é o BETA?</strong>
          <p>É a nossa versão de teste. Disponibilizamos alguns cursos para você testar, e você pode colaborar com a construção da plataforma deixando sua opiniões sobre a ferramenta respondendo a nossa pesquisa.</p>
        </div>
      </div>

      <div style="text-align: center;">
        <a
          href="{{ route('login') }}"
          class="btn-primary"
          style="
            margin: 4rem auto 2rem;
            max-width: 20rem;
            border-radius: 1rem;
          "
        >Acessar a plataforma</a>
      </div>
      <div class="how-make-tester">
        <h2>Como me tornar um testador?</h2>

        <ol>
          <li><b>Primeiro passo</b>, <a href="{{ route('register') }}" target="_blank">clique aqui</a> para se cadastrar na plataforma como aluno ou professor.<br/>Caso você já seja cadastrado, faça o <a href="{{ route('login') }}" target="_blank">login</a>.</li>
          <li><b>Segundo passo</b>, já estando cadastrado, clique em <a href="{{ route('explorer') }}" target="_blank">explorar</a> para conhecer os cursos disponíveis.</li>
          <li><b>Terceiro passo</b>, após conhecer a plataforma, responda a pesquisa para deixar seu feedback.<br/>Você encontrará o <a href="{{ config('app.feedback') }}" target="_blank">link da pesquisa</a> na página <a href="{{ route('home') }}">Home</a> ou no final dos cursos.
        </ol>
      </div>
    </div>
  </main>
  <section class="section-what-teach" id="matters">
    <div class="question">
        <h2>O que aprender?</h2>
        <p class="paragraph">
            Aqui você aprende as diversas disciplinas do Ensino Fundamental, com professores
            altamente qualificados, através de vídeos e materiais didáticos.
        </p>
        <a href="#about" class="btn-primary">Sobre</a>
    </div>
    <div class="content-matters">
        @foreach($categories as $category)
            <div>
                <strong>{{$category->title}}</strong>
                <div class="matter">
                    <img
                        src="{{$category->wallpaper}}"
                        alt="{{$category->title}}" style="
                            max-width: 12rem;
                            max-height: 20rem;
                            object-fit: cover;
                        "
                    />
                </div>
                <small class="paragraph">{{ $category->description }}</small>
            </div>
        @endforeach
    </div>
  </section>
  <section class="section-testimonial" id="about">
    <div class="container">
      <div class="content">
        <p>
          Aplicação web de ensino a distância, desenvolvida por alunos do eixo de computação do polo de Hortolândia.
        </p>
        <strong>Projeto Integrador - Univesp</strong>
      </div>
    </div>
  </section>
  @include('public_layout.footer')
  <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
</body>

</html>
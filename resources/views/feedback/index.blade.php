@extends('layout.app')
@section('head')
  <title>Feedback | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}"/>
  <style>
    h1{ margin-bottom: 1rem; }
    .form-custom{
      width: auto;
      max-width: 40rem;
    }
    .form-custom em{ color: #99a; }
    .form-custom textarea{ margin-top: .4rem; }
    .form-custom .form-group{ margin-bottom: 1.2rem; }
    .form-custom .label-check{
      display: flex;
      align-items: center;
    }
    .form-custom [type=radio]{
      height: 1.1rem !important;
      width: 1.5rem !important;
      min-width: auto !important;
    }
  </style>
@endsection
@section('content')
  <div class="container">
    <form
      method="POST"
      enctype="multipart/form-data"
      action="#"
      onsubmit="return false;"
    >
      {{ csrf_field() }}
      <div class="container-grid">
        <div class="form-custom">
          <h1>Deixe seu feedback</h1>
          <div class="form-group">
            <label for="feedback-trouble"><b>1.</b> Você teve alguma dificuldade de utilização da plataforma como erros, lentidão, etc.? Se sim, informe a página onde ocorreu, e de detalhes sobre o acontecimento. </label>
            <textarea
              name="trouble"
              id="feedback-trouble"
              placeholder="Digite se teve dificuldade ou não..."
              rows="3"
            ></textarea>
          </div>
          <div class="form-group">
            <label for="feedback-trouble"><b>2.</b> Classifique de 1 à 5 sua experiência com a plataforma, e a efetividade dela como ferramenta de ensino.</label>
            <em>(1: para ruim, 5: para muito bom)</em>
            <div style="
              margin-top: .6rem;
              display: flex;
              align-items: center;
              gap: 1rem;
              flex-wrap: wrap;
            ">
              <label class="label-check">
                <input type="radio" name="satifaction" value="1"/>1
              </label>
              <label class="label-check">
                <input type="radio" name="satifaction" value="2"/>2
              </label>
              <label class="label-check">
                <input type="radio" name="satifaction" value="3"/>3
              </label>
              <label class="label-check">
                <input type="radio" name="satifaction" value="4"/>4
              </label>
              <label class="label-check">
                <input type="radio" name="satifaction" value="5"/>5
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="feedback-trouble"><b>3.</b> Classifique de 1 à 5 qual a chance de você indicar essa plataforma para outra pessoa.</label>
            <em>(1: baixa, 5: muito alta)</em>
            <div style="
              margin-top: .6rem;
              display: flex;
              align-items: center;
              gap: 1rem;
              flex-wrap: wrap;
            ">
              <label class="label-check">
                <input type="radio" name="chance_of_indication" value="1"/>1
              </label>
              <label class="label-check">
                <input type="radio" name="chance_of_indication" value="2"/>2
              </label>
              <label class="label-check">
                <input type="radio" name="chance_of_indication" value="3"/>3
              </label>
              <label class="label-check">
                <input type="radio" name="chance_of_indication" value="4"/>4
              </label>
              <label class="label-check">
                <input type="radio" name="chance_of_indication" value="5"/>5
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="feedback-obs"><b>4.</b> Deixe sua opinião</label>
            <textarea
              name="obs"
              id="feedback-obs"
              placeholder="Digite aqui sua opinião/sugestão/comentário..."
              rows="8"
              required
            ></textarea>
          </div>
          <button
            type="submit"
            class="btn btn-primary"
            style="margin: .6rem auto; min-width: 12rem;"
          >Deixar Feedback</button>
        </div>
      </div>
    </form>
  </div>
@endsection
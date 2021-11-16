<style>
  #modalRating{
    display: none;
    z-index: 99999;
  }
  #modalRating .overlay{
    background: rgba(0,0,20,.6);
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 99999;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  #modalRating .overlay .container{
    display: block !important;
    background: #fff;
    width: 100%;
    max-width: 30rem;
    height: auto;
    max-height: calc(100vh - 2rem);
    overflow-y: auto;
    padding: 2rem 3rem;
    margin: auto 1rem;
    border-radius: 5px;
    box-shadow: 0 0 60px rgba(0,0,0,.05);
    text-align: center;
    position: relative;
  }
  #modalRating .overlay .container header{
    font-size: 1.75rem;
    font-weight: 600;
    display: flex;
    flex-wrap: inherit;
    justify-content: center;    
  }
    
  #modalRating .overlay .container section{
    font-size: 1rem;
    color: #668;
    margin-top: 1rem;
  }
  #modalRating .overlay .container section svg{
    cursor: pointer;
    transition: .4s;
  }
  #modalRating .overlay .container section svg.active{
    fill: #ffc222 !important;
  }
  #modalRating .overlay .container section svg:hover{
    fill: #ffc222 !important;
  }
  #modalRating .overlay .container button.closeModal{
    position: absolute;
    right: .5rem;
    top: .1rem;
    background: transparent;
    border: 0;
    font-size: 1.2rem;
    cursor: pointer;
  }
</style>
<div id="modalRating">
  <div class="overlay">
    <div class="container">
      <header>Avaliar</header>
      <section>
        <h3 style="color: #bbc;"></h3>
        <div id="content-stars"></div>
        <button type="button" class="btn-primary" style="
          margin: 1rem auto 0;
          height: 2.5rem;
        ">Enviar Avaliação</button>
      </section>
      <button class="closeModal" type="button" onclick="$('#modalRating').hide();">x</button>
    </div>
  </div>
</div>
<script src="{{ asset('assets/js/StarRater.js') }}"></script>
<script>
  function callRating(currentRating = 1, fn, subtitle=""){
    $('#modalRating h3').html(subtitle);
    $('#content-stars').html(`<star-rater data-rating="${currentRating}"></star-rater>`);
    $('#modalRating .btn-primary').on('click', fn);
    $('#modalRating').show();
  }
  // FUNCTION ONLOAD
  $(function(){
    $('#modalRating').bind('click', (e) => {
      if(e.target.classList.contains('overlay')){
        $('#modalRating').hide();
      }
    });
  });
</script>
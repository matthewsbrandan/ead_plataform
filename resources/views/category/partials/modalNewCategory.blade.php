<style>
  #modalNewCategory{
    /* display: none; */
    z-index: 99999;
  }
  #modalNewCategory .overlay{
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
  #modalNewCategory .overlay .container{
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
  #modalNewCategory .overlay .container header{
    font-size: 1.75rem;
    font-weight: 600;
    display: flex;
    flex-wrap: inherit;
    justify-content: center;
    padding-bottom: 1.2rem;
  }
    
  #modalNewCategory .overlay .container section{
    font-size: 1rem;
    color: #668;
    margin-top: 1rem;
  }
  #modalNewCategory .overlay .container button.closeModal{
    position: absolute;
    right: .5rem;
    top: .1rem;
    background: transparent;
    border: 0;
    font-size: 1.2rem;
    cursor: pointer;
  }
</style>
<div id="modalNewCategory">
  <div class="overlay">
    <div class="container">
      <header>Nova Categoria</header>
      <section>
        <form class="form-custom">
          <div class="form-group @if(session()->has('error-title')) have-error @endif">
            <input
              type="text"
              name="title"
              id="category-title"
              placeholder="Título da Categoria..."
              required
            />
            <span class="error-message">Este nome já está sendo utilizado</span>
          </div>
          <div class="form-group">
            <textarea
              name="description"
              id="category-description"
              placeholder="Descrição da Categoria..."
              required
            ></textarea>
          </div>
          <div class="form-group">
            <input
              type="text"
              name="wallpaper"
              id="category-wallpaper"
              required
            />
          </div>
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
      </section>
      <button class="closeModal" type="button" onclick="$('#modalNewCategory').hide();">x</button>
    </div>
  </div>
</div>
<script>
  // FUNCTION ONLOAD
  $(function(){
    $('#modalNewCategory').bind('click', (e) => {
      if(e.target.classList.contains('overlay')){
        $('#modalNewCategory').hide();
      }
    });
  });
</script>
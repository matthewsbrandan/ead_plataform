<style>
  #modalNewSection{
    display: none;
    z-index: 99999;
  }
  #modalNewSection .overlay{
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
  #modalNewSection .overlay .container{
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
  #modalNewSection .overlay .container header{
    font-size: 1.75rem;
    font-weight: 600;
    display: flex;
    flex-wrap: inherit;
    justify-content: center;
  }
    
  #modalNewSection .overlay .container section{
    font-size: 1rem;
    color: #668;
    margin-top: 1rem;
  }
  #modalNewSection .overlay .container button.closeModal{
    position: absolute;
    right: .5rem;
    top: .1rem;
    background: transparent;
    border: 0;
    font-size: 1.2rem;
    cursor: pointer;
  }
</style>
<div id="modalNewSection">
  <div class="overlay">
    <div class="container">
      <header>Nova Seção</header>
      <section>
        <form
          method="POST"
          action="{{ route('section.store') }}"
          class="form-custom"
          onsubmit="return submitLoad()"
          enctype="multipart/form-data"
        >
          {{ csrf_field() }}
          <input type="hidden" name="course_id" value="{{ $course->id }}"/>
          <div id="father-section"></div>
          <div class="form-group @if(session()->has('error-title')) have-error @endif">
            <input
              type="text"
              name="title"
              id="section-title"
              placeholder="Título da Seção..."
              required
            />
          </div>
          <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>
      </section>
      <button class="closeModal" type="button" onclick="$('#modalNewSection').hide();">x</button>
    </div>
  </div>
</div>
<script>  
  // FUNCTION ONLOAD
  $(function(){
    $('#modalNewSection').bind('click', (e) => {
      if(e.target.classList.contains('overlay')){
        $('#modalNewSection').hide();
      }
    });
  });
</script>
<style>
  #modalNewCategory{
    display: none;
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
        <form
          method="POST"
          action="{{ route('category.store') }}"
          class="form-custom"
          onsubmit="return submitLoad()"
          enctype="multipart/form-data"
        >
          {{ csrf_field() }}
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
          <label class="form-group form-control" style="padding: .4rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #99a;transform: ;msFilter:; display: inline-block; margin: auto;"><path d="M20 5h-2.586l-2.707-2.707A.996.996 0 0 0 14 2h-4a.996.996 0 0 0-.707.293L6.586 5H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2zm-8 12c-2.71 0-5-2.29-5-5 0-2.711 2.29-5 5-5s5 2.289 5 5c0 2.71-2.29 5-5 5z"></path><path d="M13 9h-2v2H9v2h2v2h2v-2h2v-2h-2z"></path></svg>
            <input
              type="file"
              accept="image/*"
              name="wallpaper"
              id="category-wallpaper"
              onchange="handleMirrorFileImg(event,$(this).parent().next())"
              style="display: none;"
              required
            />
          </label>
          <img
            src="{{ asset('assets/images/no-image.png') }}"
            class="image-mirror" alt="Imagem da Categoria"
            style="min-width: 17rem; min-height: 10rem;"
          />
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
      </section>
      <button class="closeModal" type="button" onclick="$('#modalNewCategory').hide();">x</button>
    </div>
  </div>
</div>
<script>
  const image_default = "{{ asset('assets/images/no-image.png') }}";
  // FUNCTION ONLOAD
  $(function(){
    $('#modalNewCategory').bind('click', (e) => {
      if(e.target.classList.contains('overlay')){
        $('#modalNewCategory').hide();
      }
    });

    @if(session()->has('error-new-category'))
      $('#modalNewCategory').show();
      showMessage("{!! session()->get('error-new-category') !!}");
    @endif
  });

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
</script>
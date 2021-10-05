<style>
  #searchBox{
    display: none;
    z-index: 99999;
  }
  #searchBox .overlay{
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
  #searchBox .overlay .container{
    display: block !important;
    background: #fff;
    width: 100%;
    max-width: 30rem;
    height: auto;
    max-height: calc(100vh - 2rem);
    overflow-y: auto;
    margin: auto 1rem;
    border-radius: 5px;
    box-shadow: 0 0 60px rgba(0,0,0,.05);
    text-align: center;
    position: relative;
  }
  #searchBox .form-group{
    padding: 0 1rem;
    display: flex;
    align-items: center;
    gap: .8rem;
  }
  #searchBox .form-group button{
    padding: 0;
    font-size: 0;
    background: transparent;
  }
  #searchBox .form-group input{
    flex: 1;
    height: 4.5rem;
  }
</style>
<div id="searchBox">
  <div class="overlay">
    <div class="container">
      <form>
        <div class="form-group">
          <button type="submit">
            <svg title="Pesquisar" alt="Pesquisar" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path></svg>
          </button>
          <input
            type="text"
            name="input_search"
            id="input-search"
            placeholder="Pesquisar..."
            required
          />
          <button type="button" onclick="closeSearchBox()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #445;transform: ;msFilter:;"><path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path></svg>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  function showSearchBox(){
    $('#searchBox').show();
    $('#input-search').focus();
  }
  function closeSearchBox(){
    $('#input-search').val('');
    $('#searchBox').hide();
  }
  $(function(){
    $('#searchBox').bind('click', (e) => {
      if(e.target.classList.contains('overlay')){
        closeSearchBox();
      }
    });
  });
</script>
<style>
  #modalMessage{
    display: none;
    z-index: 99999;
  }
  #modalMessage .overlay{
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
  #modalMessage .overlay .container{
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
  #modalMessage .overlay .container header{
    font-size: 1.75rem;
    font-weight: 600;
    display: flex;
    flex-wrap: inherit;
    justify-content: center;
    padding-bottom: 1.2rem;
  }
    
  #modalMessage .overlay .container section{
    font-size: 1rem;
    color: #668;
    margin-top: 1rem;
  }
  #modalMessage .overlay .container button.closeModal{
    position: absolute;
    right: .5rem;
    top: .1rem;
    background: transparent;
    border: 0;
    font-size: 1.2rem;
    cursor: pointer;
  }
</style>
<div id="modalMessage">
  <div class="overlay">
    <div class="container">
      <header>CMS</header>
      <section></section>
      <button class="closeModal" type="button" onclick="$('#modalMessage').hide();">x</button>
    </div>
  </div>
</div>
<script>
  function showMessage(content,title="{{ config('app.name') }}",content_json=false){
    $('#modalMessage').show();
    $('#modalMessage header').html(title);
    if(content_json){
      let style = "text-align: left; white-space: pre-wrap; word-break: break-all; cursor: pointer;";
      content = '<pre style="'+style+'" onclick="handleMessageCopy(event)">'+ 
        content.replaceAll(',',',\r\n')
          .replaceAll('{','{\r\n')
          .replaceAll('}','\r\n}')
        +'</pre>';
    }
    $('#modalMessage section').html(content);
  }
  function handleMessageCopy(event){
    navigator.clipboard.writeText(event.target.innerHTML);
    alert('Copiado');
  }
  // FUNCTION ONLOAD
  $(function(){
    $('#modalMessage').bind('click', (e) => {
      if(e.target.classList.contains('overlay')){
        $('#modalMessage').hide();
      }
    });
  });
</script>
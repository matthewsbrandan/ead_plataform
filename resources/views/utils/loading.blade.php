<!-- 
  REQUIRED IMPORT
  asset('assets/css/utils/loading.css')
 -->
<div id="loading">
  <div class="content">
    <span class="spinner"></span>
  </div>
</div>
<script>
  function runLoad(url){
    $('#loading').show();
    window.location.href = url;
  }
  function submitLoad(){
    $('#loading').show();
    return true;
  }
</script>
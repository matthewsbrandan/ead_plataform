<!-- 
  PARAMS:
   $value
   $id
   $label
   $name
   $placeholder
   $required (opcional)
  REQUIRED:
    js-function: handleYoutubeId
 -->
<div class="form-group">
  <label for="{{ $id }}">{{ $label }}</label>
  <input
    type="text"
    id="{{ $id }}"
    class="form-control"
    placeholder="{{ $placeholder }}"
    value="{{ $value }}"
    onchange="handleYoutubeId($(this))"
    @if(!isset($required)) required @endif
  />
  <input
    type="hidden"
    name="{{ $name }}"
    value="{{ $value }}"
  />
  <input
    type="hidden"
    name="duration"
    id="video-duration"
  />
</div>
<div id="content-iframe-youtube-api"></div>
<script>
  var tag = document.createElement('script');

  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  var player;
  function onYouTubeIframeAPIReady(id) {
    if(!id) return;

    $('#loading').show();
    player = new YT.Player('player', {
      height: '100%',
      width: '100%',
      videoId: id,
      events: { 'onReady': onPlayerReady }
    });
  }
  function onPlayerReady(event) {
    $('#loading').hide();
    let totalSeconds = event.target.getDuration()
    $('#video-duration').val(totalSeconds);
    $('#content-iframe-youtube-api').append(`
      <div class="text-gray-500" style="
        font-size: .8rem;
        display: block;
        margin-top: -0.3rem;
      ">Duração: ${handleTime(totalSeconds)}</div>
    `);
  }
  function handleTime(totalSeconds){
      hours = Math.floor(totalSeconds / 3600);
      totalSeconds %= 3600;
      minutes = Math.floor(totalSeconds / 60);
      seconds = totalSeconds % 60;

      let final = "";
      if(hours > 0) final = `${hours}h `;
      if(minutes > 0) final+= `${minutes}min `;
      if(seconds > 0) final+= `${seconds}s`;
      return final;
    }
  function handleYoutubeId(elem){
    const target = elem.next();
    let url = elem.val();
    [_, url] = url.split('?v=');
    [id, _] = url.split('&');
    console.log(id);
    target.val(id);

    $('#content-iframe-youtube-api').html(`<div id="player" style="min-width: 17rem; min-height: 10rem; margin-top: .4rem; border: 1px solid #eef;"></div>`);
    
    onYouTubeIframeAPIReady(id);
  }
</script>
<!-- 
  PARAMS:
   $value
   $id
   $label
   $name
   $placeholder
   $required (opcional)
  REQUIRED:
    js-function: handleYoutubeEmbed
 -->
<div class="form-group">
  <label for="{{ $id }}">{{ $label }}</label>
  <input
    type="text"
    id="{{ $id }}"
    class="form-control"
    placeholder="{{ $placeholder }}"
    value="{{ $value }}"
    onchange="handleYoutubeEmbed($(this))"
    @if(!isset($required)) required @endif
  />
  <input
    type="hidden"
    name="{{ $name }}"
    value="{{ $value }}"
  />
</div>
<iframe
  id="embed"
  style="min-width: 17rem; min-height: 10rem; margin-top: .4rem; border: 1px solid #eef;"
  src="{{ $value ?? '' }}"
  frameborder="0"
  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="image-mirror"
  allowfullscreen
  onReady="function(e) { console.log('target', e.target); }"
></iframe>
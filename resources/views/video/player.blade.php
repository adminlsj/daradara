<div class="aspect-ratio">
  <video id="video-js-player" style="min-width: 100%; min-height: 100%;" class="video-js vjs-waiting"
      poster='https://i.imgur.com/{{ $video->imgur }}l.png'
      oncontextmenu="return false;"
      data-setup='{ "aspectRatio":"16:9", "controls": true, "playsinline" : true, "autoplay": true, "muted": true, "preload": "auto" }'>
    <source id="_video" src="{{ $video->hd }}" type='video/mp4' />
  </video>
</div>

<script type="text/javascript">
  var xhr = new XMLHttpRequest();
  xhr.responseType = 'blob';

  xhr.onload = function() {
    var reader = new FileReader();
    
    reader.onloadend = function() {
      var byteCharacters = atob(reader.result.slice(reader.result.indexOf(',') + 1));
      var byteNumbers = new Array(byteCharacters.length);
      for (var i = 0; i < byteCharacters.length; i++) {
        byteNumbers[i] = byteCharacters.charCodeAt(i);
      }
      var byteArray = new Uint8Array(byteNumbers);
      var blob = new Blob([byteArray], {type: 'video/mp4'});
      var url = URL.createObjectURL(blob);
      
      document.getElementById('_video').src = url;
    }
    
    reader.readAsDataURL(xhr.response);
  };

  xhr.open('GET', '{{ $video->hd }}');
  xhr.send();
</script>
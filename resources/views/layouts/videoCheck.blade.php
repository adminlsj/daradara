<video id="video" style="min-width: 100%; min-height: 100%;" class="video">
  <source src="{{ $video->sd }}" type="video/mp4">
</video>

<script>
  var video = document.getElementById("video");
  video.onloadedmetadata = function() {
    alert("/watch?v=" + {{ $video->id }} + " SUCCESS");
  };
</script>
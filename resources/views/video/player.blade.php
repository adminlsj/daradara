@if ($video->outsource)
  <div class="aspect-ratio" style="background-color: black">
      <iframe src="{{ $video->sd }}" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>
  </div>
@else
  <div class="aspect-ratio">
    <video id="video-js-player" style="min-width: 100%; min-height: 100%;" class="video-js vjs-waiting"
        poster='https://i.imgur.com/{{ $video->imgur }}l.png'
        oncontextmenu="return false;"
        data-setup='{ "aspectRatio":"16:9", "controls": true, "playsinline" : true, "autoplay": true, "muted": true, "preload": "auto" }'>
      <source id="video-source" src="{{ $video->source() }}" type="video/mp4">
    </video>
  </div>
  <script src="{{ mix('js/video.js') }}"></script>
@endif
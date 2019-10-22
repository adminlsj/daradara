<div class="aspect-ratio">
  <video id="video-js-player" style="min-width: 100%; min-height: 100%;" class="video-js vjs-waiting"
      poster='https://i.imgur.com/{{ $video->imgur }}l.png'
      data-setup='{ "aspectRatio":"16:9", "controls": true, "playsinline" : true, "autoplay": true, "muted": true, "preload": "auto" }'>
    <source src="{{ $video->source }}" type='video/mp4' />
  </video>
</div>
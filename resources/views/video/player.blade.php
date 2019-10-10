<div class="aspect-ratio">
  <video id="video-js-player" style="min-width: 100%; min-height: 100%;" class="video-js vjs-waiting"
      poster='https://i.imgur.com/{{ $video->blogImgs[0]->imgur }}h.png'
      data-setup='{ "aspectRatio":"16:9", "controls": true, "playsinline" : true, "autoplay": true, "muted": true, "preload": "auto" }'>
    <source src="https://archive.org/download/{{ $video->source }}.mp4" type='video/mp4' />
    <source src="https://archive.org/download/{{ $video->source }}.ogv" type='video/ogg' />
  </video>
</div>
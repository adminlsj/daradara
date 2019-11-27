<script src="https://vjs.zencdn.net/7.5.5/video.js"></script>
<link href="https://unpkg.com/silvermine-videojs-quality-selector/dist/css/quality-selector.css" rel="stylesheet">
<script src="https://unpkg.com/silvermine-videojs-quality-selector/dist/js/silvermine-videojs-quality-selector.min.js"></script>

<div class="aspect-ratio">
  <video id="video-js-player" style="min-width: 100%; min-height: 100%;" class="video-js vjs-waiting"
      poster='https://i.imgur.com/{{ $video->imgur }}l.png'
      oncontextmenu="return false;"
      data-setup='{ "aspectRatio":"16:9", "controls": true, "playsinline" : true, "autoplay": true, "muted": true, "preload": "auto" }'>
  	<source src="{{ $video->hd }}" type="video/mp4" label="720P">
    <source src="{{ $video->sd }}" type="video/mp4" label="480P" selected="true">
  </video>
</div>

<script>
	videojs("video-js-player", {}, function() {
  	var player = this;
  	player.controlBar.addChild('QualitySelector');
	});
</script>
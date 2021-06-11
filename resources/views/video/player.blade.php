<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.css">
<div id="dplayer"></div>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/flv.js/dist/flv.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.js"></script>

<script>
  const dp = new DPlayer({
    container: document.getElementById('dplayer'),
    autoplay: true,
    theme: '#FF0000',
    preload: 'auto',
    volume: 0.7,
    video: {
      url: '{!! $video->sd !!}',
    },
  });
</script>
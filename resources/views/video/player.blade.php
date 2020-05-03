@if (!$video->outsource || strpos($video->sd, "quan.qq.com") !== FALSE || strpos($video->sd, "instagram.com") !== FALSE || $is_mobile && strpos($video->sd, "player.bilibili.com") !== FALSE )
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
        url: '{!! $video->source() !!}',
      },
    });
  </script>

@else
  <div class="aspect-ratio" style="background-color: black; background-image: url('https://i.imgur.com/TcZjkZa.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px;">
      <iframe src="{!! $video->outsource() !!}" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>
  </div>

@endif
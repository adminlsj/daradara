@if ($outsource)
  <div class="aspect-ratio" style="background-color: black; background-image: url('https://i.imgur.com/wgOXAy6.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px;">
      <iframe src="https://player.bilibili.com/player.html?bvid=BV1hD4y1Q7RD&cid=208445020&ep_id=330429&page=1&danmaku=0&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1&autoplay=1" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>
  </div>

@else
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
        url: '{!! $sd !!}',
      },
    });
  </script>

@endif
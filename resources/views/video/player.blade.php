@if ($video->outsource)
  <div class="aspect-ratio" style="background-color: black; background-image: url('https://i.imgur.com/o2hJHsfl.png'); background-position: center; background-repeat: no-repeat; background-size: 30px;">
      <iframe src="{{ $video->sd }}" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>
  </div>

@else
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.css">
  <div id="dplayer" style="width: 100%;height: auto;"></div>
  <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.js"></script>

  <script>
    const dp = new DPlayer({
      container: document.getElementById('dplayer'),
      autoplay: true,
      theme: '#d84b6b',
      preload: 'auto',
      volume: '0',
      video: {
        url: '{!! $video->source() !!}',
        pic: 'https://i.imgur.com/{{ $video->imgur }}l.png',
        thumbnails: 'https://i.imgur.com/{{ $video->imgur }}l.png',
      },
    });
  </script>

@endif
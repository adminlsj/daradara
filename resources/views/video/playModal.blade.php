<div id="playModal" class="modal fade" role="dialog">
  <div class="modal-dialog play-modal">
    <div class="modal-content">

      @if ($video->outsource)
        <div style="background-color: black; background-image: url('https://i.imgur.com/wgOXAy6.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px; position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
            <iframe src="{!! $video->sd !!}" style="border: 0; overflow: hidden; position: absolute; width: 100%; height: 100%; left: 0; top: 0;" allowfullscreen></iframe>
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
            autoplay: false,
            theme: '#FF0000',
            preload: 'auto',
            volume: 0.7,
            video: {
              url: '{!! $video->sd !!}',
            },
          });
        </script>

      @endif

    </div>
  </div>
</div>
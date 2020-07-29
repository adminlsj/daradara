@if ($outsource)
  <div class="aspect-ratio" style="background-color: black; background-image: url('https://i.imgur.com/wgOXAy6.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px;">
      <iframe src="{!! $sd !!}" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>
  </div>

@else
  @if (strpos($video->tags, '裏番') !== false && strpos($video->sd, '.mp4') !== false)
    <script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>
    <div style="background-color: white; margin-bottom: -20px; padding-bottom: 15px">
      <video id="video-id" controls>
        <source src="{!! $sd !!}" type="video/mp4">
      </video>
    </div>
    <script>
        var myFP = fluidPlayer(
          'video-id', {
            "layoutControls": {
              "controlBar": {
                "autoHideTimeout": 3,
                "animated": true,
                "autoHide": true
              },
              "autoPlay": true,
              "allowTheatre": true,
              "playPauseAnimation": true,
              "playbackRateEnabled": false,
              "allowDownload": false,
              "playButtonShowing": true,
              "fillToContainer": true,
              "primaryColor": "#FF0000",
            },
            "vastOptions": {
              "adList": [
                {
                  "roll": "preRoll",
                  "vastTag": "https://syndication.realsrv.com/splash.php?idzone=3944590",
                },
                {
                  "roll": "postRoll",
                  "vastTag": "https://syndication.realsrv.com/splash.php?idzone=3944590",
                }
              ]
            }
          }
        )
    </script>

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

@endif
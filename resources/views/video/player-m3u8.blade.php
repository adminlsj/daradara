<link rel="stylesheet" href="https://cdn.plyr.io/3.6.4/plyr.css" />
<script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
<script src="//cdn.jsdelivr.net/npm/hls.js@latest"></script>
<video style="width: 100%; height: 100%" id="player" playsinline controls poster="{{ $video->thumbH() }}" {{ $doujin ? 'loop' : '' }}>
</video>
<script>
  const source = '{!! $sd !!}';
  const video = document.querySelector('video');
  
  const player = new Plyr(video, {
    /* ads: {
      enabled: true, 
      tagUrl: 'https://syndication.realsrv.com/splash.php?idzone=4208068'
    }, */
    speed: {
      selected: 1, 
      options: [0.5, 0.75, 1, 1.25, 1.5, 2]
    },
    fullscreen: {
      enabled: true,
      fallback: true,
      iosNative: true,
      container: null
    },
    quality: {
      default: 1080
    },
    seekTime: 5,
    i18n: {
      rewind: 'Rewind 5s',
      fastForward: 'Forward 5s',
      captions: '字幕',
      disabled: '關閉',
      quality: '畫質',
      speed: '速度',
      normal: '正常',
    },
    controls: [
      'play-large', // The large play button in the center
      'rewind', // Rewind by the seek time (default 10 seconds)
      'play', // Play/pause playback
      'fast-forward', // Fast forward by the seek time (default 10 seconds)
      'progress', // The progress bar and scrubber for playback and buffering
      'current-time', // The current time of playback
      'mute', // Toggle mute
      'volume', // Volume control
      'settings', // Settings menu
      'pip', // Toggle captions
      'airplay', // Airplay options
      'fullscreen', // Toggle fullscreen
    ],
    /* duration: {{ $current->duration }} */
  });
  
  if (!Hls.isSupported()) {
    video.src = source;
  } else {
    const hls = new Hls();
    hls.loadSource(source);
    hls.attachMedia(video);
    window.hls = hls;
  }
  
  window.player = player;

  player.on('play', (event) => {
    $('#player-lang-wrapper').removeClass('lang-visible');
    $('#player-lang-wrapper').addClass('lang-hidden');
  });

  player.on('pause', (event) => {
    $('#player-lang-wrapper').removeClass('lang-hidden');
    $('#player-lang-wrapper').addClass('lang-visible');
  });

  /* video.addEventListener("timeupdate", function(){
    if(this.currentTime >= {{ $current->duration }}) {
      player.stop();
    }
  }); */
</script>
<script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
<script src="//cdn.jsdelivr.net/npm/hls.js@latest"></script>
<link rel="stylesheet" href="https://cdn.plyr.io/3.6.4/plyr.css" />
<video style="width: 100%; height: 100%" id="player" controls crossorigin playsinline data-poster="{{ $video->thumbH() }}" {{ $doujin ? 'loop' : '' }}>
  @if ($qualities == null)
    <source src="{!! $sd !!}" type="video/mp4" size="720">
  @else
    <source src="{!! $qualities[$qual] !!}" type="video/mp4" size="{{ $qual }}"> 
    @foreach ($qualities as $quality => $source)
      @if ($quality != $qual)
        <source src="{!! $source !!}" type="video/mp4" size="{{ $quality }}"> 
      @endif
    @endforeach
  @endif

  @if ($video->has_subtitles)
    <track kind="captions" label="繁體中文" srclang="zh_hant" src="{{ $video->vtt('zh_hant') }}" default>
    <track kind="captions" label="简体中文" srclang="zh_hans" src="{{ $video->vtt('zh_hans') }}">
  @endif
</video>
<script>
  const player = new Plyr('video', {
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
      default: 720
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
      'fullscreen', // Toggle fullscreen
    ],
    captions: {
      active: true, 
      language: 'zh_hant', 
      update: false,
    }
  });
  window.player = player;

  player.on('play', (event) => {
    $('#player-lang-wrapper').removeClass('lang-visible');
    $('#player-lang-wrapper').addClass('lang-hidden');
  });

  player.on('pause', (event) => {
    $('#player-lang-wrapper').removeClass('lang-hidden');
    $('#player-lang-wrapper').addClass('lang-visible');
  });

  @if ($video->has_subtitles)
    player.on('enterfullscreen', event => {
      $('.plyr__captions').addClass('plyr__fullscreen_captions');
      screen.orientation.lock('landscape');
    });

    player.on('exitfullscreen', event => {
      $('.plyr__captions').removeClass('plyr__fullscreen_captions');
      screen.orientation.lock('portrait');
    });

    var video = document.getElementById('player');
    var trackList = video.textTracks;
    video.addEventListener("webkitbeginfullscreen", function(){
      document.documentElement.style.setProperty('--webkit-text-track-display', 'block');
      if (player.currentTrack == 0) {
        trackList[0].mode = 'showing';
      } else if (player.currentTrack == 1) {
        trackList[1].mode = 'showing';
      }
    }, false);
    video.addEventListener("webkitendfullscreen", function(){
      document.documentElement.style.setProperty('--webkit-text-track-display', 'none');
      if (trackList[0].mode == 'showing') {
        player.currentTrack = 0;
      } else if (trackList[1].mode == 'showing') {
        player.currentTrack = 1;
      } else {
        player.currentTrack = -1;
      }
    }, false);
  @endif

  @if ($video->duration == null)
    player.on('loadedmetadata', function () {
      $.ajax({
         type:'GET',
         url:'/setVideoDuration',
         data: { duration: player.duration, id: '{{ $video->id }}'},
      });
    });
  @endif
</script>
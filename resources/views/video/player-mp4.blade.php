<script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
<script src="//cdn.jsdelivr.net/npm/hls.js@latest"></script>
<link rel="stylesheet" href="https://cdn.plyr.io/3.6.4/plyr.css" />
<video style="width: 100%; height: 100%" id="player" playsinline controls data-poster="{{ $video->imgurH() }}" {{ $doujin ? 'loop' : '' }}>
  @if ($video->qualities == null)
    <source src="{!! $video->sd !!}" type="video/mp4" size="720">
  @else
    @foreach ($video->qualities as $quality => $source)
      <source src="{!! $source !!}" type="video/mp4" size="{{ $quality }}"> 
    @endforeach
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
    i18n: {
      rewind: 'Rewind 5s',
      fastForward: 'Forward 5s',
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
    'pip', // Toggle captions
    'settings', // Settings menu
    'fullscreen', // Toggle fullscreen
    'airplay',
    ]
  });
  window.player = player;

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
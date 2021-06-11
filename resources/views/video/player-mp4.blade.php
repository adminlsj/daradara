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
      default: 1080
    }
  });
  window.player = player;
</script>
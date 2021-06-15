<link rel="stylesheet" href="https://cdn.plyr.io/3.6.4/plyr.css" />
<script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
<script src="//cdn.jsdelivr.net/npm/hls.js@latest"></script>
<video style="width: 100%; height: 100%" id="player" playsinline controls data-poster="{{ $video->imgurH() }}" {{ $doujin ? 'loop' : '' }}>
  <source type="application/x-mpegURL" src="{!! $video->sd !!}">
</video>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const video = document.querySelector("video");
    const source = video.getElementsByTagName("source")[0].src;
    
    // For more options see: https://github.com/sampotts/plyr/#options
    const defaultOptions = {};

    if (Hls.isSupported()) {
      // For more Hls.js options, see https://github.com/dailymotion/hls.js
      const hls = new Hls();
      hls.loadSource(source);

      // From the m3u8 playlist, hls parses the manifest and returns
      // all available video qualities. This is important, in this approach,
      // we will have one source on the Plyr player.
      hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

        // Transform available levels into an array of integers (height values).
        const availableQualities = hls.levels.map((l) => l.height)

        // Add new qualities to option
        defaultOptions.quality = {
          default: 720,
          options: availableQualities.reverse(),
          // this ensures Plyr to use Hls to update quality level
          // Ref: https://github.com/sampotts/plyr/blob/master/src/js/html5.js#L77
          forced: true,        
          onChange: (e) => updateQuality(e),
        }

        // Initialize new Plyr player with quality options
        const player = new Plyr(video, defaultOptions);
      });
      hls.attachMedia(video);
      window.hls = hls;
    } else {
      // default options with no quality update in case Hls is not supported
      const player = new Plyr(video, defaultOptions);
    }

    function updateQuality(newQuality) {
      window.hls.levels.forEach((level, levelIndex) => {
        if (level.height === newQuality) {
          console.log("Found quality match with " + newQuality);
          window.hls.currentLevel = levelIndex;
        }
      });
    }
  });
</script>
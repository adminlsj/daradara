<script type="text/javascript" src="//cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/clappr/clappr-level-selector-plugin@latest/dist/level-selector.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr.thumbnails-plugin/latest/clappr-responsive-container-plugin.js"></script>
<div><div id="player"></div></div>
<script>
	var player = new Clappr.Player({
	  source: '{!! $video->sd !!}',
	  poster: '{{ $video->imgurH() }}',
	  parentId: "#player",
	  plugins: [
	  LevelSelector
	  ],
	  levelSelectorConfig: {
	    title: '畫質',
	    labelCallback: function(playbackLevel) {
	        return playbackLevel.level.height+'p';
	    },
	  },
	});

	resizePlayer();

	function resizePlayer(){
	    const aspectRatio = 9/16;
	    const newWidth = document.getElementById('player').parentElement.offsetWidth;
	    const newHeight = 2 * Math.round(newWidth * aspectRatio/2);
	    if(player._ready) {
	      player.resize({width: newWidth, height: newHeight});
	    }   
	}
	window.onresize = resizePlayer; 
</script>
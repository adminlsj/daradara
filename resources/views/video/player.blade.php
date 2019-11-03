<script src="https://archive.org/jw/8/jwplayer.js"></script>

<div id="player-div" class="aspect-ratio">
	<div id="single-player"></div>
</div>

<script>
jwplayer('single-player').setup({
    "playlist": [
        { duration:{{ $video->duration }},
          title:"{{ $video->title }}",
          image:"https://i.imgur.com/{{ $video->imgur }}l.png",
          sources: [{
		        file: "{{ $video->sd }}",
		        label: "480p SD"
		      },{
		        file: "{{ $video->hd }}",
		        label: "720p HD"
		      }]
        },
    ],
    "aspectratio": "16:9",
    "width": "auto",
    "height": $('#player-div').width() * (9/16),
    "autostart": "true",
    "muted": "true",
});

$(window).on('resize', function(){
	var width = $('#player-div').width();
    jwplayer("single-player").resize(width, width * (9/16));
});
</script>
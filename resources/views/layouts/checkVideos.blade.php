@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div id="body" style="padding: 10px 25px; font-size: 1.2em;">
</div>

<div style="text-align: left; padding: 0px 25px;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.css">
<div style="display: none;" id="dplayer"></div>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/flv.js/dist/flv.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.js"></script>

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script>
	var page = 1;

	$(document).ready(function() {
        $("#body").append('<div>CHECK STARTED</div>');
	    load_more(page);
	});

	function load_more(page){
		$.ajax({
	        url: '?page=' + page,
	        type: "get",
	        datatype: "json",
	    })

	    .done(function(data){
	    	$("#checking").remove();
	    	$("#body").append('<div id="checking">CHECKING ' + data.id + '</div>');

	    	const dp = new DPlayer({
	            container: document.getElementById('dplayer'),
	            autoplay: false,
	            theme: '#d84b6b',
	            preload: 'auto',
	            volume: 0,
	            video: {
	              url: data.link,
	            },
	        });
	        dp.video.pause();

	        $('video').on('error', function() {
	            var newVid = '<div>' + data.id + '&nbsp;' + data.title + ' FAILED</div>';
		        $("#body").append(newVid);
	        });

	        if (page == data.count){
	        	var message = '<div>CHECK FINISHED</div>';
	        	$("#body").append(message);
	        	$("#checking").remove();
	        	$('.ajax-loading').html(" ");
	            return;
	        } else {
	        	page++;
		        load_more(page);
	        }
	    })

	    .fail(function(jqXHR, ajaxOptions, thrownError){
	    });
	}
</script>

@endsection
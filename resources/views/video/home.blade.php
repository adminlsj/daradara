@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5;">

		@if (Auth::check() && auth()->user()->subscribes()->first())
			<div class="subscribes-tab">
		    	<a id="default-tag" class="load-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
				@foreach (auth()->user()->recommendTags() as $tag)
					<a class="load-tag-videos" style="margin-right: 5px;">#{{ $tag }}</a>
				@endforeach
			</div>
			<div class="row no-gutter load-more-container">
		        <div class="video-sidebar-wrapper" style="position: relative;">
			        <div id="sidebar-results"><!-- results appear here --></div>
			        <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		        </div>
		    </div>

		@else
			<div class="home-genre-banner-wrapper home" style="background-color: #EFE3E3;">
				<img style="width: auto; height: 100%; float: right" src="https://i.imgur.com/Qlawqysh.png">
				<div class="home-genre-panel">
		  			<img class="lazy" style="float:left; width: 70px; height: 70px; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="https://i.imgur.com/sMSpYFXb.jpg" data-src="https://i.imgur.com/i0qmoB7.gif" data-srcset="https://i.imgur.com/i0qmoB7.gif">
		  			<div style="height: 70px; margin-left: 85px; padding-top: 9px; padding-right: 15px;">
		  				<div style="font-size: 1.5em; font-weight: bold; color: #444444">動漫領域</div>
		  				<div class="hidden-xs" style="color: gray; font-weight: bold; color: #666666">只有你想不到的，沒有你找不到的。</div>
		  				<div class="hidden-sm hidden-md hidden-lg" style="color: gray; font-weight: bold; color: #666666">只有想不到，沒有找不到</div>
		  			</div>
		        </div>
		        <div class="subscribes-tab home-anime-wrapper" style="border: none; position: absolute; bottom: -10px;">
			    	<a id="default-anime-tag" class="load-home-tag-videos active" style="margin-right: 5px;">全部<span class="hidden-xs">推薦內容</span></a>
			    	<a class="load-home-tag-videos" style="margin-right: 5px;">#正版動漫</a>
			    	<a class="load-home-tag-videos" style="margin-right: 5px;">#anime1</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#同人動畫</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#動漫講評</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#MAD·AMV</a>
				</div>
		    </div>
			<div class="row no-gutter load-more-container" style="margin-top: 13px; padding-bottom: 5px;">
		        <div class="video-sidebar-wrapper" style="position: relative;">
			        <div id="sidebar-anime-results" style="position: relative"><!-- results appear here --></div>
			        <div style="text-align: center;" class="ajax-anime-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		        </div>
		    </div>

		    <div class="home-genre-banner-wrapper home" style="background-color: #EAEBF7;">
				<img style="width: auto; height: 100%; float: right; -webkit-transform: scaleX(-1); transform: scaleX(-1);" src="https://i.imgur.com/Qq8Vf7Uh.jpg">
				<div class="home-genre-panel">
		  			<img class="lazy" style="float:left; width: 70px; height: 70px; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="https://i.imgur.com/sMSpYFXb.jpg" data-src="https://i.imgur.com/F4MuxgA.gif" data-srcset="https://i.imgur.com/F4MuxgA.gif">
		  			<div style="height: 70px; margin-left: 85px; padding-top: 9px; padding-right: 15px">
		  				<div style="font-size: 1.5em; font-weight: bold; color: #444444">明星專區</div>
		  				<div style="color: gray; font-weight: bold; color: #666666">日本明星．綜藝．劇集<span class="hidden-xs">．直播．情報</span></div>
		  			</div>
		        </div>
		        <div class="subscribes-tab home-artist-wrapper" style="border: none; position: absolute; bottom: -10px;">
			    	<a id="default-artist-tag" class="load-home-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
			    	<a class="load-home-tag-videos" style="margin-right: 5px;">#嵐Arashi</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#Gimy劇迷</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#貴婦松子Deluxe</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#Downtown</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#倫敦靴子1號2號</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#佐藤健</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#石原聰美</a>
					<a class="load-home-tag-videos" style="margin-right: 5px;">#新垣結衣</a>
				</div>
		    </div>
			<div class="row no-gutter load-more-container" style="margin-top: 13px; padding-bottom: 5px;">
		        <div class="video-sidebar-wrapper" style="position: relative;">
			        <div id="sidebar-artist-results" style="position: relative"><!-- results appear here --></div>
			        <div style="text-align: center;" class="ajax-artist-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		        </div>
		    </div>

		    <div class="home-genre-banner-wrapper home" style="background-color: #C5E2EC;">
				<img style="width: auto; height: 100%; float: right; padding-right: 15px" src="https://i.imgur.com/7YbBOwNh.jpg">
				<div class="home-genre-panel">
		  			<img class="lazy" style="float:left; width: 70px; height: 70px; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="https://i.imgur.com/sMSpYFXb.jpg" data-src="https://i.imgur.com/wR0VuiK.gif" data-srcset="https://i.imgur.com/wR0VuiK.gif">
		  			<div style="height: 70px; margin-left: 85px; padding-top: 9px; padding-right: 15px">
		  				<div style="font-size: 1.5em; font-weight: bold; color: #444444">日本人氣YouTuber</div>
		  				<div style="color: gray; font-weight: bold; color: #666666"><span class="hidden-xs">日本超人氣</span>YouTuber & Twitter推主</div>
		  			</div>
		        </div>
		        <div class="subscribes-tab home-youtuber-wrapper" style="border: none; position: absolute; bottom: -10px;">
			    	<a id="default-youtuber-tag" class="load-home-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#日本快嘴小姐姐</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#神谷惠里奈</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#俄羅斯佐藤</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#費米研究所</a>
				</div>
		    </div>
			<div class="row no-gutter load-more-container" style="margin-top: 13px; padding-bottom: 5px;">
		        <div class="video-sidebar-wrapper" style="position: relative;">
			        <div id="sidebar-youtuber-results" style="position: relative"><!-- results appear here --></div>
			        <div style="text-align: center;" class="ajax-youtuber-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		        </div>
		    </div>
		@endif
	</div>
</div>

@endsection
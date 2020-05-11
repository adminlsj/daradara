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
		        <div class="video-sidebar-wrapper">
			        <div id="sidebar-results"><!-- results appear here --></div>
			        <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		        </div>
		    </div>

		@else
			<div style="padding: 10px 0px;">
				<div class="paravi-padding-setup">
		  			<img class="lazy" style="float:left; border-radius: 50%; width: 70px; height: 70px; border: 1px solid #f5f5f5;" src="https://i.imgur.com/sMSpYFXb.jpg" data-src="https://i.imgur.com/kYs5o10h.jpg" data-srcset="https://i.imgur.com/kYs5o10h.jpg">
		  			<div style="height: 70px; margin-left: 85px; padding-top: 10px;">
		  				<div style="font-size: 1.5em; font-weight: bold">動漫領域</div>
		  				<div style="color: gray; font-weight: bold">動漫愛好者</div>
		  			</div>
		        </div>
		    </div>
			<div class="subscribes-tab home-anime-wrapper" style="margin-bottom: 13px;">
		    	<a id="default-anime-tag" class="load-home-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
		    	<a class="load-home-tag-videos" style="margin-right: 5px;">#正版動漫</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#同人動畫</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#動漫講評</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#MAD·AMV</a>
			</div>
			<div class="row no-gutter load-more-container">
		        <div class="video-sidebar-wrapper">
			        <div id="sidebar-anime-results"><!-- results appear here --></div>
			        <div style="text-align: center;" class="ajax-anime-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		        </div>
		    </div>

			<div style="padding: 10px 0px;  margin-top: 10px;">
				<div class="paravi-padding-setup">
		  			<img class="lazy" style="float:left; border-radius: 50%; width: 70px; height: 70px; border: 1px solid #f5f5f5;" src="https://i.imgur.com/sMSpYFXb.jpg" data-src="https://i.imgur.com/OQu2LYfh.jpg" data-srcset="https://i.imgur.com/OQu2LYfh.jpg">
		  			<div style="height: 70px; margin-left: 85px; padding-top: 10px;">
		  				<div style="font-size: 1.5em; font-weight: bold">明星專區</div>
		  				<div style="color: gray; font-weight: bold">日星最新情報</div>
		  			</div>
		        </div>
		    </div>
			<div class="subscribes-tab home-artist-wrapper" style="margin-bottom: 13px;">
		    	<a id="default-artist-tag" class="load-home-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
		    	<a class="load-home-tag-videos" style="margin-right: 5px;">#佐藤健</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#嵐Arashi</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#石原聰美</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#貴婦松子Deluxe</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#Downtown</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#倫敦靴子1號2號</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#新垣結衣</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#橋本環奈</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#上白石萌音</a>
			</div>
			<div class="row no-gutter load-more-container">
		        <div class="video-sidebar-wrapper">
			        <div id="sidebar-artist-results"><!-- results appear here --></div>
			        <div style="text-align: center;" class="ajax-artist-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		        </div>
		    </div>

			<div style="padding: 10px 0px; margin-top: 10px;">
				<div class="paravi-padding-setup">
		  			<img class="lazy" style="float:left; border-radius: 50%; width: 70px; height: 70px; border: 1px solid #f5f5f5;" src="https://i.imgur.com/sMSpYFXb.jpg" data-src="https://i.imgur.com/lnTT7tmh.jpg" data-srcset="https://i.imgur.com/lnTT7tmh.jpg">
		  			<div style="height: 70px; margin-left: 85px; padding-top: 10px;">
		  				<div style="font-size: 1.5em; font-weight: bold">日本人氣YouTuber</div>
		  				<div style="color: gray; font-weight: bold">路人明星</div>
		  			</div>
		        </div>
		    </div>
			<div class="subscribes-tab home-youtuber-wrapper" style="margin-bottom: 13px;">
		    	<a id="default-youtuber-tag" class="load-home-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#日本快嘴小姐姐</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#神谷惠里奈</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#俄羅斯佐藤</a>
				<a class="load-home-tag-videos" style="margin-right: 5px;">#費米研究所</a>
			</div>
			<div class="row no-gutter load-more-container">
		        <div class="video-sidebar-wrapper">
			        <div id="sidebar-youtuber-results"><!-- results appear here --></div>
			        <div style="text-align: center;" class="ajax-youtuber-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		        </div>
		    </div>
		    <br>
		@endif
	</div>
</div>

@endsection
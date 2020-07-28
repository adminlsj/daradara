@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
    <div class="hidden-xs hidden-sm hidden-md sidebar-menu">
      @include('video.sidebarMenu', ['theme' => 'white'])
    </div>

    <div class="main-content">
		<div style="background-color:#F5F5F5;">
			<div class="row no-gutter">
				<div class="col-md-8 single-show-player">
					@include('video.singleShowWatch')
				</div>

				<div class="col-md-4 single-show-list">

					<div style="padding-bottom: 7px;">
						@if (strpos($video->tags, '裏番') !== false)
							<div class="hidden-xs hidden-sm" id='b9c-b26930' style="margin: 15px 15px 10px 15px;"><script>var b9c=typeof(b9c)!=="undefined"?b9c:{choose:function(c){c.sort(function(e,f){return f.Rank-e.Rank});var a=c.filter(function(e){return !b9c.isChosen(e)});if(a.length>0){var d=a[0];this.chosen.push(d.Placement);return d}else{var b=c[0];this.chosen=[b.Placement];return b}},chosen:[],isChosen:function(a){return this.chosen.indexOf(a.Placement)>=0}};(function(){var a=function(){var f=null;try{if(window.parent.frameElement!=null&&window.parent.document.referrer!=""){f=window.parent.document.referrer}else{f=window.parent.document.location.href}}catch(g){f=document.referrer}return f};var c=function(e){b9c.b26930={init:function(){var l=encodeURIComponent(window.document.referrer);var k=encodeURIComponent(Math.floor(Math.random()*100000+1));var o=encodeURIComponent(new Date().getTimezoneOffset());var f=document.location.ancestorOrigins;var i=(top!==self)?(f!==undefined&&f.length>1?f[f.length-1]:a()):document.location.href;var h="https://impactserving.com/banner.engine?id=75b4ac7f-9a66-41df-8b31-822964ff008b&z=26930&cid=b9c&rand="+k+"&ver=async&time="+o+"&referrerurl="+l+"&abr=false&curl="+encodeURIComponent(i);var m=document.createElement("script");m.type="text/javascript";m.async=true;m.src=h;m.onload=m.onreadystatechange=function(p){if(!this.readyState||this.readyState=="loaded"||this.readyState=="complete"){m.onload=m.onreadystatechange=null;if(typeof(b9c.b26930.Media)!=="undefined"){g()}else{n();g()}}};var j=document.getElementsByTagName("script")[0];j.parentNode.insertBefore(m,j);function n(){if(b9c.b26930.Medias!=="undefined"){b9c.b26930.Media=b9c.choose(b9c.b26930.Medias)}}function g(r){var p=e("#b9c-b26930");var q;if(b9c.b26930.Media.BannerDiv){q=e("<div />",{style:"display: block; margin: 0 auto; padding: 0; border: none; height: "+b9c.b26930.Media.Height+"px; width: "+b9c.b26930.Media.Width+"px;"});e.ajax({dataType:"html",url:"https://impactserving.com"+b9c.b26930.Media.Url+"&cu=",cache:false,success:function(s){q.html(s)}})}else{q=e("<iframe />",{scrolling:"no",style:"z-index: 5000001; margin: 0px; padding: 0px; border: none; width: "+b9c.b26930.Media.Width+"px; height: "+b9c.b26930.Media.Height+"px;",src:"https://impactserving.com"+b9c.b26930.Media.Url+"&cu="})}q.appendTo(p)}}};b9c.b26930.init()};if(typeof jQuery==="undefined"){var b=document.createElement("script");b.type="text/javascript";b.src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js";b.onload=b.onreadystatechange=function(){c(window.jQuery)};var d=document.getElementsByTagName("script")[0];d.parentNode.insertBefore(b,d)}else{c(window.jQuery)}})();</script></div>
						@else
							<div class="hidden-xs hidden-sm" style="margin: 15px 15px 10px 15px;">
								<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- fixed square ad -->
								<ins class="adsbygoogle"
								     style="display:inline-block;width:100%;height:305px;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); border-radius: 3px; background-color: #F9F9F9;"
								     data-ad-client="ca-pub-4485968980278243"
								     data-ad-slot="2765106128"></ins>
								<script>
								     (adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							</div>
						@endif

						@if ($watch && Request::get('list') != $watch->id)
							<div id="suggested-watch-wrapper" class="related-watch-wrap hover-opacity-all" style="background-color: #F9F9F9">
								<a href="{{ route('video.playlist') }}?list={{ $watch->id }}" class="row no-gutter">
								  <div style="padding-right: 4px; position: relative; width: 175px;" class="col-xs-6 col-sm-6 col-md-6">
								    <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $video->imgur16by9() }}" data-src="{{ $watch->videos->first()->imgurL() }}" data-srcset="{{ $watch->videos->first()->imgurL() }}" alt="{{ $watch->title }}">
								    <span>
								      	<div style="margin: 0;position: absolute; top: calc(50% + 3px); left: 50%; transform: translate(-50%, -50%);">
									      	<div>{{ $watch->videos->count() }}</div>
									      	<i style="font-size: 1.6em; margin-right: -2px" class="material-icons">playlist_play</i>
									    </div>
								    </span>
								  </div>
								  <div style="padding-left: 4px; width: calc(100% - 175px)" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
								    <h4>{{ $watch->title }}</h4>
								  </div>
								</a>
								<div style="position: absolute; bottom: 7px; left: 182px">
									<img class="lazy" style="float:left; width: 18px; height: 18px; margin-top: 1px" src="{{ $video->user->avatarCircleB() }}" data-src="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}" data-srcset="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}">
									<a href="{{ route('user.show', [$video->user]) }}" style="color: darkgray; font-size: 0.8em; margin-left: 5px;">{{ $video->user->name }}</a>
								</div>
							</div>
						@endif

						<div id="video-playlist-wrapper">
							<div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 14px; padding-bottom: 28px;" src="https://i.imgur.com/wgOXAy6.gif"/></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
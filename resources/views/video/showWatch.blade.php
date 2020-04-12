@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'dark'])
@endsection

@section('content')
    <div class="hidden-sm hidden-xs sidebar-menu">
      @include('video.sidebarMenu', ['theme' => 'dark'])
    </div>

    <div class="main-content">
		<div style="background-color:#1F1F1F; color: white;">
			<div class="video-sidebar-wrapper">
				<div class="row">
					<div class="col-md-8 single-show-player">
						@include('video.singleShowWatch')
					</div>

					<div class="col-md-4 single-show-list">
						<div style="padding: 6px 15px; background-color: #595959; height: 48px;">
							<a href="{{ route('user.show', [$video->user()]) }}"><img class="lazy" style="float:left; border-radius: 50%; width: 36px; height: 36px;" src="{{ $video->user()->avatarCircleB() }}" data-src="{{ $video->user()->avatar == null ? $video->user()->avatarDefault() : $video->user()->avatar->filename }}" data-srcset="{{ $video->user()->avatar == null ? $video->user()->avatarDefault() : $video->user()->avatar->filename }}"></a>
		    				<h5 style="margin-top: 11px; margin-left: 65px"><a style="text-decoration: none; color: white" href="{{ route('user.show', [$video->user()]) }}">{{ $video->user()->name }}</a></h5>
		    				@if ($watch != null)
		    					<div style="float: right; margin-top: -23px;">
				    				@include('video.intro-subscribe-wrapper', ['tag' => $video->watch()->title])
			    				</div>
		    				@endif
	    				</div>

	    				<div style="padding: 0px 15px; position: relative; padding-right: 40px; width: 100%; overflow-x: hidden; overflow-y: hidden; height: 39px; margin-bottom: 3px; margin-top: 13px" class="subscribes-tab-inverse subscribe-tags-wrapper">
						  @foreach ($video->tags() as $tag)
						      <a style="margin-right: 3px; text-decoration: none; display: inline-block; margin-bottom: 10px; padding: 5px 10px; font-size: 0.9em" href="{{ route('video.subscribeTag') }}?query={{ $tag }}">#{{ $tag }}</a>
						  @endforeach
						  <div style="position:absolute; top:3px; right:13px; cursor: pointer; color: darkgray" class="pull-right toggle-subscribe-tags"><i class="material-icons noselect toggle-subscribe-tags-icon">expand_more</i></div>
						</div>

						<div style="padding-bottom: 7px;">
							<div class="hidden-xs hidden-sm" style="margin: 4px 15px 15px 15px;">
								<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<ins class="adsbygoogle"
								     style="display:block; border: 1px solid white"
								     data-ad-client="ca-pub-4485968980278243"
								     data-ad-slot="8455082664"
								     data-ad-format="auto"
								     data-full-width-responsive="true"></ins>
								<script>
								     (adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							</div>

							<!--<div style="position: relative; margin-top: -15px" class="tab">
								@if (Request::get('list') != '')
									<a href="{{ route('video.playlist') }}?list={{ $video->watch()->id }}"><button class="tablinks video-tablinks">{{ $video->watch()->title }}</button></a>
									<a style="position:absolute; top:14px; right:63px; text-decoration: none; {{ $prev != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $prev }}"><i class="material-icons noselect">skip_previous</i></a>
									<a style="position:absolute; top:14px; right:13px; text-decoration: none; margin-left: 8px; {{ $next != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $next }}"><i class="material-icons noselect">skip_next</i></a>
								@else
									<a><button class="tablinks video-tablinks">相關影片</button></a>
								@endif
							</div>-->

							@if ($video->watch() && Request::get('list') != $video->watch()->id)
								<div id="suggested-watch-wrapper" style="padding: 0px 15px" class="hover-opacity-all">
									<a href="{{ route('video.playlist') }}?list={{ $video->watch()->id }}" class="row no-gutter">
									  <div style="padding-right: 4px; position: relative;" class="col-xs-6 col-sm-6 col-md-6">
									    <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->watch()->videos()->first()->imgurL() }}" data-srcset="{{ $video->watch()->videos()->first()->imgurL() }}" alt="{{ $video->watch()->title }}">
									    <span>
									      	<div style="margin: 0;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
										      	<div>{{ $video->watch()->videos()->count() }}</div>
										      	<i style="font-size: 1.6em; margin-right: -2px" class="material-icons">playlist_play</i>
										    </div>
									    </span>
									  </div>
									  <div style="padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
									    <h4 style="margin-top:0px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em; color:white;">{{ $video->watch()->title }}</h4>
									    <p style="color: darkgray; margin-top: 1px; margin-bottom: 0px; font-size: 0.85em;">{{ $video->watch()->user()->name }}</p>
									  </div>
									</a>
								</div>
							@endif

							<div id="video-playlist-wrapper">
								<div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 14px; padding-bottom: 28px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
							</div>
						</div>

						@if ($is_mobile)
							<div style="border-top: solid 1px #383838;">
								@include('video.comment-section-wrapper')
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
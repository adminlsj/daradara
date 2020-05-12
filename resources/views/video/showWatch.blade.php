@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
    <div class="hidden-sm hidden-xs sidebar-menu">
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
						<div class="hidden-xs hidden-sm" style="margin: 15px 15px 0px 15px;">
							<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
							     style="display:block; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); border-radius: 3px"
							     data-ad-client="ca-pub-4485968980278243"
							     data-ad-slot="8455082664"
							     data-ad-format="auto"
							     data-full-width-responsive="true"></ins>
							<script>
							     (adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</div>

						<div style="position: relative; margin-top: 5px" class="tab">
							@if (Request::get('list') != '')
								<a href="{{ route('video.playlist') }}?list={{ $video->watch()->id }}"><button style="color: #222222; font-weight: 400;" class="tablinks video-tablinks">{{ $video->watch()->title }}</button></a>
								<a style="position:absolute; top:12px; right:56px; text-decoration: none; {{ $prev != false ? 'color: #414141;' : 'pointer-events: none; color: #B9B9B9;' }}" href="{{ route('video.watch') }}?v={{ $prev }}&list={{ $video->watch()->id }}"><i class="material-icons noselect">skip_previous</i></a>
								<a style="position:absolute; top:12px; right:15px; text-decoration: none; margin-left: 8px; {{ $next != false ? 'color: #414141;' : 'pointer-events: none; color: #B9B9B9;' }}" href="{{ route('video.watch') }}?v={{ $next }}&list={{ $video->watch()->id }}"><i class="material-icons noselect">skip_next</i></a>
							@endif
						</div>

						@if ($video->watch() && Request::get('list') != $video->watch()->id)
							<div class="hidden-xs hidden-sm" style="margin-top: 6px"></div>
							<div id="suggested-watch-wrapper" class="related-watch-wrap hover-opacity-all">
								<a href="{{ route('video.playlist') }}?list={{ $video->watch()->id }}" class="row no-gutter">
								  <div style="padding-right: 4px; position: relative;" class="col-xs-6 col-sm-6 col-md-6">
								    <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->watch()->videos()->first()->imgurL() }}" data-srcset="{{ $video->watch()->videos()->first()->imgurL() }}" alt="{{ $video->watch()->title }}">
								    <span>
								      	<div style="margin: 0;position: absolute; top: calc(50% + 3px); left: 50%; transform: translate(-50%, -50%);">
									      	<div>{{ $video->watch()->videos()->count() }}</div>
									      	<i style="font-size: 1.6em; margin-right: -2px" class="material-icons">playlist_play</i>
									    </div>
								    </span>
								  </div>
								  <div style="padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
								    <h4>{{ $video->watch()->title }}</h4>
								  </div>
								</a>
								<div style="position: absolute; bottom: 7px; left: calc(50% + 7px);">
									<img class="lazy" style="float:left; width: 18px; height: 18px; border: 1px solid #f5f5f5; margin-top: 1px" src="{{ $video->user()->avatarCircleB() }}" data-src="{{ $video->user()->avatar == null ? $video->user()->avatarDefault() : $video->user()->avatar->filename }}" data-srcset="{{ $video->user()->avatar == null ? $video->user()->avatarDefault() : $video->user()->avatar->filename }}">
									<a href="{{ route('user.show', [$video->user()]) }}" style="color: darkgray; font-size: 0.8em; margin-left: 5px;">{{ $video->user()->name }}</a>
								</div>
							</div>
						@endif

						<div id="video-playlist-wrapper">
							<div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 14px; padding-bottom: 28px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
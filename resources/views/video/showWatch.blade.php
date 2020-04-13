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
				<div class="col-md-8 single-show-player" style="background-color: #F9F9F9;">
					@include('video.singleShowWatch')
				</div>

				<div class="col-md-4 single-show-list">

					<div style="padding-bottom: 7px;">
						<div class="hidden-xs hidden-sm" style="margin: 15px 15px 0px 15px;">
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

						<div style="position: relative; margin-top: 5px" class="tab">
							@if (Request::get('list') != '')
								<a href="{{ route('video.playlist') }}?list={{ $video->watch()->id }}"><button style="color: #222222; font-weight: 400;" class="tablinks video-tablinks">{{ $video->watch()->title }}</button></a>
								<a style="position:absolute; top:12px; right:56px; text-decoration: none; {{ $prev != false ? 'color: #414141;' : 'pointer-events: none; color: #B9B9B9;' }}" href="{{ route('video.watch') }}?v={{ $prev }}&list={{ $video->watch()->id }}"><i class="material-icons noselect">skip_previous</i></a>
								<a style="position:absolute; top:12px; right:15px; text-decoration: none; margin-left: 8px; {{ $next != false ? 'color: #414141;' : 'pointer-events: none; color: #B9B9B9;' }}" href="{{ route('video.watch') }}?v={{ $next }}&list={{ $video->watch()->id }}"><i class="material-icons noselect">skip_next</i></a>
							@else
								<a><button style="color: #222222; font-weight: 400" class="tablinks video-tablinks">相關影片</button></a>
							@endif
						</div>

						@if ($video->watch() && Request::get('list') != $video->watch()->id)
							<div class="hidden-xs hidden-sm" style="margin-top: 6px"></div>
							<div id="suggested-watch-wrapper" style="padding: 0px 15px; padding-top: 8px" class="hover-opacity-all">
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
								    <h4 style="margin-top:3px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em; color:#222222;">{{ $video->watch()->title }}</h4>
								    <p style="color: dimgray; margin-top: 3px; margin-bottom: 0px; font-size: 0.85em;">{{ $video->watch()->user()->name }}</p>
								  </div>
								</a>
							</div>
						@endif

						<div id="video-playlist-wrapper">
							<div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 14px; padding-bottom: 28px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
						</div>
					</div>

					@if ($is_mobile)
						<div style="padding: 0px 15px">
							<hr style="margin: 0px; margin-top: 7px;">
							@include('video.comment-section-wrapper')
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
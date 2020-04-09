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
						<div style="padding: 10px 15px; background-color: #595959; height: 70px;">
							<a href="{{ route('user.show', [$watch->user()]) }}"><img class="lazy" style="float:left; border-radius: 50%; width: 50px; height: 50px;" src="{{ $watch->user()->avatarCircleB() }}" data-src="{{ $watch->user()->avatar == null ? $watch->user()->avatarDefault() : $watch->user()->avatar->filename }}" data-srcset="{{ $watch->user()->avatar == null ? $watch->user()->avatarDefault() : $watch->user()->avatar->filename }}"></a>
		    				<h5 style="margin-top: 16px; margin-left: 65px"><a style="text-decoration: none; color: white" href="{{ route('user.show', [$watch->user()]) }}">{{ $watch->user()->name }}</a></h5>
		    				<div style="float: right; margin-top: -21px; width: 75px">
			    				@include('video.intro-subscribe-wrapper', ['tag' => $watch->title])
		    				</div>
	    				</div>
						<div style="position: relative;" class="tab">
							<a href="{{ route('video.playlist') }}?list={{ $video->watch()->id }}"><button style="{{ $is_program ? '' : 'display:none' }}" class="tablinks video-tablinks">{{ $is_program ? $video->watch()->title : '相關影片' }}</button></a>
							@if ($is_program)
								<a style="position:absolute; top:14px; right:65px; text-decoration: none; {{ $prev != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $prev }}"><i class="material-icons noselect">skip_previous</i></a>
								<a style="position:absolute; top:14px; right:13px; text-decoration: none; margin-left: 8px; {{ $next != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $next }}"><i class="material-icons noselect">skip_next</i></a>
							@endif
						</div>

						<div style="padding: 0px 15px; position: relative; padding-right: 40px; width: 100%; overflow-x: hidden; overflow-y: hidden; height: 39px; margin-bottom: 7px; margin-top: -5px" class="subscribes-tab-inverse subscribe-tags-wrapper">
						  @foreach ($video->tags() as $tag)
						      <a style="margin-right: 3px; text-decoration: none; display: inline-block; margin-bottom: 10px; padding: 5px 10px; font-size: 0.9em" href="{{ route('video.subscribeTag') }}?query={{ $tag }}">#{{ $tag }}</a>
						  @endforeach
						  <div style="position:absolute; top:3px; right:13px; cursor: pointer; color: darkgray" class="pull-right toggle-subscribe-tags"><i class="material-icons noselect toggle-subscribe-tags-icon">expand_more</i></div>
						</div>

						@if ($is_program)
							<div style="padding-bottom: 7px;">

								<div class="hidden-xs hidden-sm" style="margin: 6px 15px 0px 15px;">
									<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
									<ins class="adsbygoogle"
									     style="display:block; border: solid 1px white"
									     data-ad-client="ca-pub-4485968980278243"
									     data-ad-slot="8455082664"
									     data-ad-format="auto"
									     data-full-width-responsive="true"></ins>
									<script>
									     (adsbygoogle = window.adsbygoogle || []).push({});
									</script>
								</div>

								<div id="video-playlist-wrapper">
									<div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 14px; padding-bottom: 28px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
								</div>
							</div>
						@endif

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
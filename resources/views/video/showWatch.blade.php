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
						<div class="hidden-xs hidden-sm" style="margin: 15px 15px 10px 15px;">
							@if (strpos($video->sd, 'avbebe.com') !== false)
								<div class="hidden-xs hover-opacity-all load-more-wrapper video-card" style="margin-bottom: 15px; width: calc(100% + 8px); margin-left: -4px;">
									<a style="color: inherit; text-decoration: none;" href="{{ route('blog.read') }}?r={{ $blog->id }}" title="{{ $blog->title }}" target="_blank">
									    <div style="position: relative;">
									        <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-top-right-radius: 3px;" src="{{ $blog->imgur16by9() }}" data-src="{{ $blog->imgurL() }}" data-srcset="{{ $blog->imgurL() }}" alt="{{ $blog->title }}">
										    <div style="background-color: #F9F9F9; padding: 7px 10px; height: 73px; border-radius: 3px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1);">
											    <div style="font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $blog->title }}</div>
											    <div style="color: darkgray; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.85em; margin-top: 3px;">laughseejapan.com</div>
											</div>
										</div>
									</a>
								</div>
							@else
								<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- fixed square ad -->
								<ins class="adsbygoogle"
								     style="display:inline-block;width:100%;height:305px;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); border-radius: 3px; background-color: #F9F9F9;"
								     data-ad-client="ca-pub-4485968980278243"
								     data-ad-slot="2765106128"></ins>
								<script>
								     (adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							@endif
						</div>

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

						<div class="related-watch-wrap hover-opacity-all hidden-md hidden-lg" style="background-color: #F9F9F9">
							@if (strpos($video->sd, 'avbebe.com') !== false)
								<a href="{{ route('blog.read') }}?r={{ $blog->id }}" class="row no-gutter" target="_blank">
								  <div style="padding-right: 4px; width: 175px;" class="col-xs-6 col-sm-6 col-md-6">
								    <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $blog->imgur16by9() }}" data-src="{{ $blog->imgurL() }}" data-srcset="{{ $blog->imgurL() }}" alt="{{ $blog->title }}">
								  </div>
								  <div style="padding-left: 4px; width: calc(100% - 175px)" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
								    <h4>{{ $blog->title }}</h4>
								  </div>
								</a>

								<div style="position: absolute; bottom: 7px; left: 182px;">
									<img class="lazy" style="float:left; width: 18px; height: 18px; margin-top: 1px" src="{{ $blog->user->avatarCircleB() }}" data-src="{{ $blog->user->avatar == null ? $blog->user->avatarDefault() : $blog->user->avatar->filename }}" data-srcset="{{ $blog->user->avatar == null ? $blog->user->avatarDefault() : $blog->user->avatar->filename }}">
									<a href="{{ route('user.show', [$blog->user]) }}" style="color: darkgray; font-size: 0.8em; margin-left: 5px;">laughseejapan</a>
								</div>
							@endif
						</div>

						<div id="video-playlist-wrapper">
							<div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 14px; padding-bottom: 28px;" src="https://i.imgur.com/wgOXAy6.gif"/></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
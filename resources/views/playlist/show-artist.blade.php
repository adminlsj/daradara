@extends('layouts.app')

@section('head')
    @parent
		<title>{{ $title }}&nbsp;-&nbsp;H動漫/裏番/線上看&nbsp;-&nbsp;Hanime1.me</title>
		<meta name="title" content="{{ $title }} - H動漫/裏番/線上看 - Hanime1.me">
		<meta name="description" content="{{ $description }}">
@endsection

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div class="nav-bottom-padding home-content-wrapper">

  <div style="position: relative; margin-top: 0px; padding-top: 100px;">

    <div class="content-padding-new playlist-rows-top">
      <a class="home-rows-header" style="text-decoration: none; margin-bottom: 20px;">
        <h5 id="playitems-count" data-count="{{ $count }}" style="color: #8e9194;">{{ $count }} 位作者</h5>
        <h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">
        	{{ $title }}
        </h3>
      </a>

      <button class="no-select playlist-show-btn playlist-show-edit-btn" style="margin-right: 3px;">
        <span id="playlist-show-edit-btn-icon" style="vertical-align: middle; font-size: 25px; margin-top: -5px; margin-right: 5px; cursor: pointer;" class="material-icons-outlined">edit_note</span><span id="playlist-show-edit-btn-text">編輯訂閱</span>
      </button>

      <button class="no-select playlist-show-btn" style="background-color: transparent; color: white; margin-left: 4px; margin-right: 0px; outline: 0;" data-toggle="modal" data-target="#shareModal">
        <span style="vertical-align: middle; font-size: 18px; margin-top: -3px; margin-right: 5px; cursor: pointer;" class="material-icons">share</span>分享
      </button>
    </div>

    <div id="home-rows-wrapper" style="position: relative; margin-top: 0px;">
    	<div class="home-rows-videos-wrapper" style="white-space: normal; margin-left: -2px; margin-right: -2px;">
				@foreach ($results as $subscribe)
					<div id="playlist-show-video-wrapper-{{ $subscribe->artist->id }}" class="home-rows-videos-div col-xs-4 col-sm-3 col-md-2 col-lg-2" style="position: relative; display: inline-block; margin-bottom:50px;">

					  <div style="position: relative;">
					    <div class="multiple-link-wrapper search-doujin-videos home-doujin-videos home-artist-card" style="display: inline-block; padding-right: 3px; width: 100% !important;">
								<a class="overlay" href="{{ route('home.search') }}?query={{ $subscribe->artist->name }}"></a>
								<div class="card-mobile-panel inner">
									<div style="position: relative; width: 100% !important;">
										<img style="width: 100% !important;" src="https://vdownload.hembed.com/image/icon/card_artist_background.jpg?secure=_QCcfQgpiOO8qV2a0t4ulQ==,4865085854">
										<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 3px" src="{{ $subscribe->artist->avatar_temp }}">
								    </div>

									<div class="card-mobile-details-wrapper" style="margin-top: -1px; padding: 0 3px;">
										<div style="text-decoration: none; color: black;">
											<div class="card-mobile-title search-artist-title" style="font-weight: normal; color: #e5e5e5;">{{ $subscribe->artist->name }}</div>

											<div class="card-mobile-genre-wrapper" style="margin-top: 3px; margin-left: -2px">
												<span style="text-decoration: none; font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user search-artist-count">{{ $subscribe->artist->videos_count }} 部影片</span>
											</div>
										</div>
									</div>
								</div>
							</div>

					    @if ($editable)
					      <form style="display: none;" class="playitem-delete-form" action="{{ route('playitem.delete') }}">
					        {{ csrf_field() }}

					        <input class="playlist-show-id" name="playlist-show-id" type="hidden" value="{{ request('list') }}">
					        <input class="playlist-show-video-id" name="playlist-show-video-id" type="hidden" value="{{ $subscribe->artist->id }}">

					        <div style="position: absolute; top: 0px; right: 0; background-color: black; height: 30px; width: 30px; cursor: pointer; z-index: 100;" class="no-select playitem-delete-btn">
					          <span class="material-icons" style="font-size: 30px; color: white; padding-left: 0px;">clear</span>
					        </div>
					      </form>
					    @endif
					  </div>
					</div>
				@endforeach
			</div>
    </div>

    <div class="{{ $doujin ? 'search-doujin-pagination-desktop-margin' : 'search-hentai-pagination-desktop-margin' }} search-pagination hidden-xs">{!! $results->appends(request()->query())->links() !!}</div>
		<div style="{{ $doujin ? 'margin-top: -26px;' : 'margin-top: -29px;' }}" class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $results->appends(request()->query())->onEachSide(1)->links() !!}</div>

		@include('ads.search-banner-panel')

		<div class="hidden-sm hidden-md hidden-lg" style="text-align: center; margin-bottom: -40px; {{ $results->lastPage() == 1 ? 'margin-top: 32px' : 'margin-top: -12px' }}">
			<!-- JuicyAds v3.1 -->
			<script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
			<ins id="941419" data-width="300" data-height="112"></ins>
			<script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':941419});</script>
			<!--JuicyAds END-->
		</div>

		<div class="hidden-xs"><br><br><br></div>
    <div class="hidden-xs hidden-md hidden-lg"><br></div>
    <div class="hidden-sm hidden-md hidden-lg"><br><br></div>

  </div>

</div>

@if ($playlist && $editable)
	@include('playlist.edit-modal')
@endif

@if (!Auth::check())
	@include('user.signUpModal')
  @include('user.loginModal')
@endif

@include('video.shareModal')
@include('layouts.nav-bottom')

@endsection
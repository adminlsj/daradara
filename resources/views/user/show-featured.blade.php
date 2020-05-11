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

		<div class="user-show-general-panel" style="padding-top: 20px;">
      <div class="paravi-padding-setup">
  			<img class="lazy" style="float:left; border-radius: 50%; width: 70px; height: 70px; border: 1px solid #f5f5f5;" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
  			@if (Auth::check() && $user->id == Auth::user()->id)
          <form style="width:auto; height: auto; font-size: 1em; margin-top: 9px;" id="logout-form" action="{{ route('logout') }}" method="POST" class="pull-right">
              {{ csrf_field() }}
              <button style="background-color: inherit !important; color: #d84b6b" class="btn btn-info" type="submit">登出</button>
          </form>
  				<a style="width:auto; height: auto; font-size: 1em; margin-top: 9px; margin-right: 5px; color: white" class="btn btn-info pull-right" href="{{ route('user.userEditUpload', $user) }}">上傳影片</a>
  			@endif
  			<div style="height: 70px; margin-left: 85px; padding-top: 10px;">
  				<div style="font-size: 1.5em; font-weight: bold">{{ $user->name }}</div>
  				<div style="color: gray; font-weight: bold">{{ $subscribers }} 位訂閱者</div>
  			</div>
      </div>

      <div class="subscribes-tab" style="margin-top: 20px; margin-bottom: 0px;">
        <a href="{{ route('user.show', [$user, 'featured']) }}" class="active" style="margin-right: 5px;">首頁</a>
        <a href="{{ route('user.show', [$user, 'videos']) }}" style="margin-right: 5px;">影片</a>
        <a href="{{ route('user.show', [$user, 'playlists']) }}" style="margin-right: 5px;">播放清單</a>
        <a href="{{ route('user.show', [$user, 'about']) }}" style="margin-right: 5px;">簡介</a>
      </div>
		</div>

    <div style="margin-top: 25px"></div>

    <div class="row no-gutter load-more-container" style="margin-top: -20px;">
      <a href="{{ route('user.show', [$user, 'videos']) }}" style="color: inherit; text-decoration: none">
        <h3 class="user-show-title">近期動態<i style="font-size: 0.85em; vertical-align: middle; margin-top: -3px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
      </a>
      <div class="video-sidebar-wrapper">
        @foreach ($videos as $video)
          <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
            @include('video.new-singleLoadMoreVideos')
          </div>
        @endforeach
      </div>
    </div>

    <div class="row no-gutter load-more-container" style="margin-top: -5px">
      <a href="{{ route('user.show', [$user, 'videos']) }}" style="color: inherit; text-decoration: none">
        <h3 class="user-show-title">發燒影片<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
      </a>
      <div class="video-sidebar-wrapper">
        @foreach ($trendings as $video)
          <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
            @include('video.new-singleLoadMoreVideos')
          </div>
        @endforeach
      </div>
    </div>

    <div class="row no-gutter load-more-container" style="margin-top: -5px">
      <a href="{{ route('user.show', [$user, 'playlists']) }}" style="color: inherit; text-decoration: none">
        <h3 class="user-show-title">播放清單<i style="font-size: 0.85em; vertical-align: middle; margin-top: -3px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
      </a>
      <div class="video-sidebar-wrapper">
        @foreach ($playlists as $watch)
          @if ($watch->videos()->first())
            <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
              @include('video.singleLoadMoreSliderPlaylists', ['video' => $watch->videos()->first()])
            </div>
          @endif
        @endforeach
      </div>
    </div>

    @if ($user->id == 746)
      <div class="row no-gutter load-more-container" style="margin-top: -10px">
        <a href="{{ route('user.show', [5190, 'playlists']) }}" style="color: inherit; text-decoration: none">
          <h3 class="user-show-title">精選頻道<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
        </a>
        <div class="video-sidebar-wrapper">
          @foreach (App\Watch::where('user_id', 5190)->inRandomOrder()->get() as $watch)
            @if ($watch->videos()->first())
              <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
              @include('video.singleLoadMoreSliderPlaylists', ['video' => $watch->videos()->first()])
              </div>
            @endif
          @endforeach
        </div>
      </div>
    @endif

	</div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection
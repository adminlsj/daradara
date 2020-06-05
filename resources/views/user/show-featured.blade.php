@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $user->name }}&nbsp;-&nbsp;娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $user->name }} - 娛見日本 LaughSeeJapan">
    <meta name="description" content="{{ $user->name }}">
@endsection

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5;">

    <div class="row no-gutter load-more-container" style="padding-top: 19px;">
      <img class="lazy user-show-title" style="float:left; width: 56px; height: 56px; border-top-left-radius: 3px; border-bottom-left-radius: 3px; margin-right: 15px" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
      <h5 class="user-show-title" style="font-size: 1em; color: #555555; font-weight: normal; line-height: 0px">{{ $subscribers }} 位訂閱者</h5>
      <h3 class="user-show-title no-select" style="font-size: 2em; margin-top: 4px; margin-bottom: 10px"><span style="font-size: 0.93em">{{ $user->name }}</span></h3>
    </div>

    <div class="subscribes-tab" style="border: none; margin-top: 4px; margin-bottom: 0px">
        <a href="{{ route('user.show', [$user, 'featured']) }}" class="active" style="margin-right: 5px;">首頁</a>
        <a href="{{ route('user.show', [$user, 'videos']) }}" style="margin-right: 5px;">影片</a>
        <a href="{{ route('user.show', [$user, 'playlists']) }}" style="margin-right: 5px;">播放清單</a>
        <a href="{{ route('user.show', [$user, 'about']) }}" style="margin-right: 5px;">簡介</a>
        @if (Auth::check() && $user->id == Auth::user()->id)
          <a href="{{ route('user.userEditUpload', $user) }}" style="margin-right: 5px;">上傳影片</a>
          <form id="logout-form" style="display: inline-block; margin-top: -10px; margin-bottom: -10px" action="{{ route('logout') }}" method="POST">
              {{ csrf_field() }}
              <button style="margin: 0px; margin-right: 5px; border: none;" type="submit">登出</button>
          </form>
        @endif
    </div>

    <div class="row no-gutter load-more-container">
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

    <div class="row no-gutter load-more-container" style="margin-top: 5px;">
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

    <div class="row no-gutter load-more-container" style="margin-top: 5px;">
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
      <div class="row no-gutter load-more-container" style="margin-top: 5px;">
        <a href="{{ route('user.show', [5190]) }}" style="color: inherit; text-decoration: none">
          <h3 class="user-show-title">精選頻道<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
        </a>
        <div class="video-sidebar-wrapper">
          @foreach (App\Watch::where('user_id', 5190)->inRandomOrder()->limit(8)->get() as $watch)
            @if ($watch->videos()->first())
              <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
                @include('video.singleLoadMoreSliderPlaylists', ['video' => $watch->videos()->first()])
              </div>
            @endif
          @endforeach
        </div>
      </div>
    @endif

    <br>

	</div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection
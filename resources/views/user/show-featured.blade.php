@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $user->name }}&nbsp;-&nbsp;娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $user->name }} - 娛見日本 LaughSeeJapan">
    <meta name="description" content="{{ $user->name }}">
@endsection

@section('nav')
	@include('nav.main', ['theme' => 'white'])
@endsection

@section('content')

<div class="main-content">
	<div style="background-color: #F5F5F5;">

    @include('user.show-panel')

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
          <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
            @include('video.singleLoadMoreSliderPlaylists', ['video' => $watch->videos->first()])
          </div>
        @endforeach
      </div>
    </div>

    @if ($user->id == 746)
      <div class="row no-gutter load-more-container" style="margin-top: 5px;">
        <a href="{{ route('user.show', [5190]) }}" style="color: inherit; text-decoration: none">
          <h3 class="user-show-title">精選頻道<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
        </a>
        <div class="video-sidebar-wrapper">
          @foreach (App\Watch::withVideos()->where('user_id', 5190)->inRandomOrder()->limit(8)->select('id', 'title')->get() as $watch)
            <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
              @include('video.singleLoadMoreSliderPlaylists', ['video' => $watch->videos->first()])
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <br>

	</div>
</div>

@endsection
<div class="row no-gutter load-more-container" style="padding-top: 19px;">
  <h5 class="user-show-title" style="font-size: 1em; color: #555555; font-weight: normal; line-height: 0px">只有想不到，沒有找不到</h5>
  <h3 class="user-show-title" style="font-size: 2em; margin-top: 5px; margin-bottom: 10px">LaughSeeJapan</h3>
</div>

<div class="row no-gutter load-more-container">
  <a href="{{ route('genre.index', 'anime') }}" style="color: inherit; text-decoration: none">
    <h3 class="user-show-title">動畫卡通<i style="font-size: 0.85em; vertical-align: middle; margin-top: -3px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
  </a>
  <div class="video-sidebar-wrapper">
    @foreach ($animeVid as $video)
      <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
        @include('video.new-singleLoadMoreVideos')
      </div>
    @endforeach
  </div>
</div>

<div class="row no-gutter load-more-container" style="margin-top: 5px;">
  <a href="{{ route('genre.index', 'aninews') }}" style="color: inherit; text-decoration: none">
    <h3 class="user-show-title">動漫情報<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
  </a>
  <div class="video-sidebar-wrapper">
    @foreach ($animeNews as $video)
      <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
        @include('blog.new-singleLoadMoreBlogs')
      </div>
    @endforeach
  </div>
</div>

<div class="row no-gutter load-more-container" style="margin-top: 5px;">
  <a href="{{ route('genre.index', 'variety') }}" style="color: inherit; text-decoration: none">
    <h3 class="user-show-title">綜藝頻道<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
  </a>
  <div class="video-sidebar-wrapper">
    @foreach ($variety as $video)
      <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
        @include('video.new-singleLoadMoreVideos')
      </div>
    @endforeach
  </div>
</div>

<div class="row no-gutter load-more-container" style="margin-top: 5px;">
  <a href="{{ route('genre.index', 'artist') }}" style="color: inherit; text-decoration: none">
    <h3 class="user-show-title">明星專區<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
  </a>
  <div class="video-sidebar-wrapper">
    @foreach ($artist as $video)
      <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
        @include('video.new-singleLoadMoreVideos')
      </div>
    @endforeach
  </div>
</div>

<div class="row no-gutter load-more-container" style="margin-top: 5px;">
  <a href="{{ route('genre.index', 'meme') }}" style="color: inherit; text-decoration: none">
    <h3 class="user-show-title">迷因翻譯<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
  </a>
  <div class="video-sidebar-wrapper">
    @foreach ($meme as $video)
      <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
        @include('video.new-singleLoadMoreVideos')
      </div>
    @endforeach
  </div>
</div>

<div class="row no-gutter load-more-container" style="margin-top: 5px;">
  <a href="{{ route('genre.index', 'daily') }}" style="color: inherit; text-decoration: none">
    <h3 class="user-show-title">日本生活<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
  </a>
  <div class="video-sidebar-wrapper">
    @foreach ($daily as $video)
      <div class="{{ $loop->iteration > 4 ? 'hidden-xs hidden-sm' : ''}}">
        @include('blog.new-singleLoadMoreBlogs')
      </div>
    @endforeach
  </div>
</div>

<br>
<div class="navbar hidden-lg hidden-md">
  <a href="/" class="{{ Request::is('/') ? 'active' : ''}}">
    <i class="material-icons">home</i>
    <span style="padding-right: 1px;">主頁</span>
  </a>
  <a href="{{ route('video.rank') }}" class="{{ Request::is('*rank*') ? 'active' : ''}}">
    <i style="font-size: 26px;" class="material-icons">whatshot</i>
    <span>熱門</span>
  </a>
  <a href="{{ route('video.variety') }}" class="{{ strpos(Request::path(), 'variety' ) !== false || (Request::has('v') && $current->genre == 'variety') ? 'active' : ''}}">
    <i style="padding-left: 1px; font-size: 25px;" class="material-icons">live_tv</i>
    <span>綜藝</span>
  </a>
  <a href="{{ route('video.drama') }}" class="{{ strpos(Request::path(), 'drama' ) !== false || (Request::has('v') && $current->genre == 'drama') ? 'active' : ''}}">
    <i style="padding-left: 2px;" class="material-icons">movie_filter</i>
    <span>日劇</span>
  </a>
  <a href="{{ route('video.anime') }}" class="{{ strpos(Request::path(), 'anime' ) !== false || (Request::has('v') && $current->genre == 'anime') ? 'active' : ''}}">
    <i style="font-size: 26px;" class="material-icons">palette</i>
    <span>動漫</span>
  </a>
</div>
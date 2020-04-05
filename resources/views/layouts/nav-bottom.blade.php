<div style="{{ Request::is('watch') || Request::is('search') ? '' : 'display:none' }}" class="bottom-nav hidden-lg hidden-md {{ $theme == 'dark' ? 'dark-theme-nav-bottom' : 'white-theme-nav-bottom' }}">
  <a href="/" class="{{ Request::is('/') ? 'active' : ''}}">
    <i class="material-icons">home</i>
    <span style="padding-right: 1px;">主頁</span>
  </a>
  <a href="{{ route('video.subscribes') }}" class="{{ Request::is('*subscribes*') ? 'active' : ''}}">
    <i style="font-size: 25px; position: relative" class="material-icons">subscriptions</i>
    <span style="padding-right: 1px;">訂閱</span>
    @if (Auth::check() && strpos(auth()->user()->alert, 'subscribe') !== false)
      <span style="position: absolute; top: -5px; right: calc(60% - 9px)" class="alert-circle"></span>
    @endif
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
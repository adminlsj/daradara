<div class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
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
  <a href="{{ route('video.rank') }}" class="{{ Request::is('*rank*') ? 'active' : '' }}">
    <i style="padding-left: 1px; font-size: 26px;" class="material-icons">whatshot</i>
    <span>發燒影片</span>
  </a>
  <a href="{{ route('video.newest') }}" class="{{ Request::is('*newest*') ? 'active' : '' }}">
    <i style="padding-left: 2px; font-size: 25px;" class="material-icons">explore</i>
    <span>最新內容</span>
  </a>
  <a href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login') }}" class="{{ Request::is('*user*') ? 'active' : '' }}">
    <i style="font-size: 26px;" class="material-icons">video_library</i>
    <span>媒體庫</span>
  </a>
</div>
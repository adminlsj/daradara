<div class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/" class="{{ Request::is('/') ? 'active' : ''}}">
    <i style="font-size: 23px; margin-top: 3px" class="material-icons">home</i>
    <span style="padding-right: 1px;">主頁</span>
  </a>
  <a href="{{ route('video.subscribes') }}" class="{{ Request::is('*subscribes*') ? 'active' : ''}}">
    <i style="font-size: 23px; position: relative" class="material-icons">subscriptions</i>
    <span style="padding-right: 1px;">訂閱項目</span>
    @if (Auth::check() && strpos(auth()->user()->alert, 'subscribe') !== false)
      <span style="position: absolute; top: -5px; right: calc(60% - 9px)" class="alert-circle"></span>
    @endif
  </a>
  <a href="{{ route('video.rank') }}" class="{{ Request::is('*rank*') ? 'active' : '' }}">
    <i style="padding-left: 0px; font-size: 24px;" class="material-icons">whatshot</i>
    <span>發燒影片</span>
  </a>
  @if (Auth::check() && auth()->user()->subscribes()->first())
    <a href="{{ route('video.recommend') }}" class="{{ Request::is('*recommend*') ? 'active' : '' }}">
      <i style="padding-left: 2px; font-size: 25px; margin-top: 3px" class="material-icons">explore</i>
      <span>最新推薦</span>
    </a>
  @else
    <a href="{{ route('video.newest') }}" class="{{ Request::is('*newest*') ? 'active' : '' }}">
      <i style="padding-left: 2px; font-size: 25px; margin-top: 3px" class="material-icons">explore</i>
      <span>最新內容</span>
    </a>
  @endif
  <a href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login') }}" class="{{ Request::is('*user*') ? 'active' : '' }}">
    <i style="font-size: 23px;" class="material-icons">video_library</i>
    <span>媒體庫</span>
  </a>
</div>
<div class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/" class="{{ Request::is('/') ? 'active' : ''}}">
    <i style="font-size: 24px; margin-top: 7px" class="material-icons">home</i>
    <span style="padding-right: 1px;">主頁</span>
  </a>
  <a href="{{ route('home.search') }}" class="{{ Request::is('*search*') ? 'active' : '' }}">
    <i style="font-size: 27px; margin-top: 5px" class="material-icons">search</i>
    <span>搜索</span>
  </a>
  <a href="{{ Auth::check() ? route('home.list') : route('login') }}" class="{{ Request::is('*subscribes*') ? 'active' : ''}}">
    <i style="font-size: 23px; position: relative; margin-top: 7px" class="material-icons">subscriptions</i>
    <span style="padding-right: 1px;">訂閱項目</span>
    @if (Auth::check() && strpos(auth()->user()->alert, 'subscribe') !== false)
      <span style="position: absolute; top: -5px; right: calc(60% - 9px)" class="alert-circle"></span>
    @endif
  </a>
  <a href="{{ route('home.search') }}?query=&sort=觀看次數" class="{{ Request::is('*rank*') ? 'active' : '' }}">
    <i style="padding-left: 0px; font-size: 24px;  margin-top: 7px" class="material-icons">whatshot</i>
    <span>發燒影片</span>
  </a>
  <a href="{{ route('home.search') }}" class="{{ Request::is('*newest*') ? 'active' : '' }}">
    <i style="padding-left: 2px; font-size: 25px; margin-top: 6px" class="material-icons">explore</i>
    <span>最新內容</span>
  </a>
</div>
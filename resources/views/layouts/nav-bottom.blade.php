<div style="z-index: 10000 !important; border-top: 1px solid #222222; {{ Request::is('*watch*') ? 'display:none;' : '' }}" class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/">
    @if (Request::is('/'))
      <i style="font-size: 24px; margin-top: 6px; color: white" class="material-icons">home</i>
      <span style="padding-right: 1px; color: white">主頁</span>
    @else
      <i style="font-size: 24px; margin-top: 7px;" class="material-icons-outlined">home</i>
      <span style="padding-right: 1px;">主頁</span>
    @endif
  </a>
  <a href="{{ route('home.search') }}">
    @if (Request::is('*search'))
      <i style="font-size: 26px; margin-top: 5px;" class="material-icons">search</i>
    @else
      <i style="font-size: 26px; margin-top: 6px;" class="material-icons-outlined">search</i>
    @endif
    <span>搜索</span>
  </a>
  <a href="{{ Auth::check() ? route('home.list') : route('login') }}">
    @if (Request::is('*list*'))
      <i style="font-size: 22px; margin-top: 6px; color: white" class="material-icons">subscriptions</i>
      <span style="padding-right: 1px; color: white">我的清單</span>
    @else
      <i style="font-size: 22px; margin-top: 7px;" class="material-icons-outlined">subscriptions</i>
      <span style="padding-right: 1px;">我的清單</span>
    @endif
  </a>
  <a href="{{ route('home.search') }}?query=&sort=本日排行">
    @if (Request::is('*rank*'))
      <i style="padding-left: 0px; font-size: 24px; margin-top: 5px;" class="material-icons{{ Request::is('*rank*') ? '' : '-outlined' }}">whatshot</i>
    @else
      <i style="padding-left: 0px; font-size: 24px; margin-top: 6px;" class="material-icons{{ Request::is('*rank*') ? '' : '-outlined' }}">whatshot</i>
    @endif
    <span>發燒影片</span>
  </a>
  <a href="{{ route('home.search') }}">
    @if (Request::is('*newest*'))
      <i style="padding-left: 2px; font-size: 24px; margin-top: 5px" class="material-icons{{ Request::is('*newest*') ? '' : '-outlined' }}">explore</i>
    @else
      <i style="padding-left: 2px; font-size: 24px; margin-top: 6px" class="material-icons{{ Request::is('*newest*') ? '' : '-outlined' }}">explore</i>
    @endif
    <span>最新內容</span>
  </a>
</div>
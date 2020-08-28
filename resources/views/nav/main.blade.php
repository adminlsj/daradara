<div id="main-nav">
  <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
  </a>
  <a class="nav-item hidden-xs" href="/">主頁</a>
  <a class="nav-item" href="{{ route('home.search') }}">H動漫</a>
  <a href="https://www.laughseejapan.com/search?query=%E5%8B%95%E6%BC%AB" target="_blank" class="nav-item" href="javascript:void(0)">動畫卡通</a>
  <a class="nav-item hidden-xs" href="{{ route('home.search') }}">最新內容</a>
  <a class="nav-item" href="{{ Auth::check() ? route('home.list') : route('login') }}">我的清單</a>

  <a style="padding-right: 0px" class="nav-icon pull-right hidden-xs" href="{{ Auth::check() ? route('home.list') : route('login') }}"><span style="vertical-align: middle;" class="material-icons">account_circle</span></a>
  <a class="nav-icon pull-right hidden-xs" href="javascript:void(0)"><span style="vertical-align: middle;" class="material-icons">notifications</span></a>
  <a class="nav-icon pull-right hidden-xs" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons">search</span></a>
</div>
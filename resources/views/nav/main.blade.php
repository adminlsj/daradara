<div id="main-nav" style="z-index: 10000 !important" class="main-nav{{ Request::is('*watch*') || Request::is('*download*') ? '-video-show' : '' }}">
  <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
  </a>
  <a class="nav-item hidden-xs" href="/">主頁</a>
  <a class="nav-item hidden-xs" href="{{ route('home.search') }}">H動漫</a>
  <a class="nav-item hidden-xs" href="https://laughseejapan.com/user/746">動畫卡通</a>
  <a class="nav-item hidden-xs" href="{{ route('home.search') }}">最新內容</a>
  <!-- <a class="nav-item hidden-xs" href="{{ route('home.search') }}?query=&tags%5B%5D=同人&year=&month=&sort=">同人作品</a>
  <a class="nav-item hidden-xs" href="{{ route('home.search') }}?query=&tags%5B%5D=Cosplay&year=&month=&sort=">Cosplay</a> -->
  <a class="nav-item hidden-xs" href="{{ Auth::check() ? route('home.list') : route('login') }}">我的清單</a>

  <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ Auth::check() ? route('home.list') : route('login') }}"><span style="vertical-align: middle;" class="material-icons">account_circle</span></a>
  <a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons">search</span></a>
  <a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle;" class="material-icons">video_call</span></a>
</div>
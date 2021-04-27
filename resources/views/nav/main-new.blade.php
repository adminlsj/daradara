<div id="main-nav" style="z-index: 10000 !important; background-color: gray" class="main-nav{{ Request::is('*watch*') || Request::is('*download*') ? '-video-show' : '' }}">
  <a href="/" style="padding-right: 2.5%; color: white; font-size: 2em; font-stretch: condensed;">
    <span style="color: crimson">H</span>ANIME1<span style="color: crimson">.</span>ME
  </a>
  <form id="main-search-form">
      <div style="position: absolute; top: 0px; left: 245px;">
        <input id="nav-query" name="query" style="box-shadow: none; border: 1px solid rgba(58,60,63,.85); background-color: #202020; font-size: 1.1em;border-radius: 2px; height: 40px; padding-left: 5px; color: darkgray; padding-bottom: 2px; font-weight: 500; transition: .3s cubic-bezier(0,0,.2,1);" type="text" value="{{ request('query') }}" placeholder="搜索">
      </div>
      <div style="position: absolute; top: 0px; left: 400px;">
        <button style="height: 40px;" type="submit">
          <i style="vertical-align: middle; margin-top: -35px" class="material-icons">search</i>
        </button>
      </div>
  </form>
  <form id="hentai-form" action="{{ route('home.search') }}" method="GET">
    <input type="hidden" id="query" name="query" value="{{ Request::get('query') }}">
  </form>
  <!-- <a class="nav-item hidden-xs" href="/">主頁</a>
  <a class="nav-item hidden-xs" href="{{ route('home.search') }}">H動漫</a>
  <a href="https://www.laughseejapan.com/search?query=%E5%8B%95%E6%BC%AB" target="_blank" class="nav-item hidden-xs" href="javascript:void(0)">動畫卡通</a>
  <a class="nav-item hidden-xs" href="{{ route('home.search') }}">最新內容</a>
  <a class="nav-item hidden-xs" href="{{ Auth::check() ? route('home.list') : route('login') }}">我的清單</a>

  <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ Auth::check() ? route('home.list') : route('login') }}"><span style="vertical-align: middle;" class="material-icons">account_circle</span></a>
  <a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons">search</span></a>
  <a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle;" class="material-icons">video_call</span></a> -->
</div>
<div id="comic-nav" style="z-index: 10000 !important; position: static !important; background-color: #1f1f1f !important; background-image: none; transition: none; height: 50px; line-height: 50px;" class="main-nav">
  <a href="{{ route('comic.index') }}" style="padding-right: 15px; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
  </a>

  <div style="display: inline-block; vertical-align: top; width: 20%; position: relative; margin-right: 47px;">
    <form id="search-form" action="{{ route('comic.search') }}" method="GET">
        <input name="query" style="background-color: #4d4d4d; height: 40px; border: none; border-top-left-radius: 5px; border-bottom-left-radius: 5px; width: 100%; outline: none; padding-left: 10px; color: white; font-weight: 400" type="text" value="{{ request('query') }}">
        <button class="hover-lighter" style="display: inline-block; height: 40px; position: absolute; top: 5px; right: -38px; border: none; background-color: crimson; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
          <span style="color: white; font-weight: bolder; padding-left: 2px;" class="material-icons">search</span>
        </button>
    </form>
  </div>


  <a id="comic-random-nav-item" style="padding-left: 10px; cursor: pointer;" class="comic-nav-item nav-item hidden-xs">隨機推薦</a>
  <a class="comic-nav-item nav-item hidden-xs" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">標籤</a>
  <a class="comic-nav-item nav-item hidden-xs" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">作者</a>
  <a class="comic-nav-item nav-item hidden-xs" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">角色</a>
  <a class="comic-nav-item nav-item hidden-xs" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">同人</a>
  <a class="comic-nav-item nav-item hidden-xs" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">社團</a>
  <a class="comic-nav-item nav-item hidden-xs" href="/">H動漫</a>

  <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}"><span style="vertical-align: middle;" class="material-icons">account_circle</span></a>
  <a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons">search</span></a>
  <a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle;" class="material-icons">video_call</span></a>
</div>
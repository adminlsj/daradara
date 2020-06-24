<nav style="border-bottom: 1px solid #e9e9e9; background-color: white; z-index: 999; padding: 0px 85px; margin-bottom: -50px; position: relative;" class="white-theme-nav-main">
  <div class="container-fluid">
    <div style="height: 124px;">

      <a style="position: absolute; top: 33px; left: 59px;" href="/">
        <div class="hover-opacity-all">
          <img style="height: 30px;" src="https://i.imgur.com/p4CUaD6.png">
        </div>
      </a>

      <form id="search-form" class="hidden-xs pull-left nav-search-input" action="{{ route('video.search') }}" method="GET">
          <i style="position: absolute; top: 12px; right: 100px; color: dimgray" class="material-icons">search</i>
          <input name="query" style="box-shadow: none; border: 1px solid #e8eaed; background-color: white; font-size: 1.15em;border-radius: 7px; height: 48px; padding-left: 20px; color: #222222; padding-bottom: 2px; font-weight: normal; color: black;" type="text" value="{{ request('query') }}" placeholder="搜索">
      </form>

      <a class="nav-item-icon" style="top: 31px; right: 97px;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i class="material-icons">account_circle</i></a>
      <a class="nav-item-icon" style="top: 32px; right: 148px;" href="{{ route('video.subscribes') }}"><i class="material-icons" style="font-size: 1.7em">subscriptions</i></a>
      <a class="nav-item-icon" style="top: 31px; right: 196px;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i class="material-icons">video_call</i></a>

      <div class="row search-sub-nav" style="position: absolute; left: 119px; bottom: 0px; font-size: 0.94em;">
        <span style="display:inline-block; border-bottom:3px solid #333333; padding-bottom:10px; ">
          <a style="font-weight: bold;">全部</a>
        </span>
        <a>影片</a>
        <a>播放清單</a>
        <a>用戶</a>
      </div>

    </div>
  </div>
</nav>

@include('layouts.nav-search')

@include('layouts.nav-bottom')
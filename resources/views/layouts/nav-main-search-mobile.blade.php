<nav style="border-bottom: 1px solid #e9e9e9; background-color: white; z-index: 999; margin-bottom: -50px; position: relative; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1);" class="nav-main-original white-theme-nav-main">
  <div class="container-fluid">
    <div style="height: 135px;">

      <a class="pull-left" style="text-decoration: none; line-height: 50px;" href="/">
          <img id="nav-image" style="height: 22px;" src="https://i.imgur.com/DWGvZ7Y.png">
      </a>

      <form id="search-form" style="margin-top: 3px; margin-left: -5px; width: 100%;" class="pull-left nav-search-input" action="{{ route('video.search') }}" method="GET">
          <input name="query" style="box-shadow: none; border: 1px solid #e8eaed; background-color: white; font-size: 1.15em;border-radius: 7px; height: 40px; padding-left: 13px; color: #222222; padding-bottom: 2px; font-weight: normal; color: black; -webkit-appearance: none; width: calc(100% + 10px);" type="text" value="{{ request('query') }}" placeholder="搜索">
          <a class="search-submit-btn" type="submit" style="position: absolute; top: 4px; right: 2px; color: dimgray; cursor: pointer;"><i class="material-icons">search</i></a>
      </form>

      <a class="hidden-md hidden-lg nav-item-icon" style="right: 16px;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i class="material-icons">account_circle</i></a>
      <a href="{{ route('video.subscribes') }}" class="hidden-md hidden-lg nav-item-icon" style="top: 10px; right: 62px; cursor: pointer;"><i style="font-size: 1.65em" class="material-icons">subscriptions</i></a>
      <a id="nav-account-icon" class="pull-right hidden-md hidden-lg nav-item-icon" style="right: 105px;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i class="material-icons">video_call</i></a>

      <div class="row search-sub-nav" style="position: absolute; left: 30px; bottom: 0px; font-size: 0.94em;">
        <span style="display:inline-block; border-bottom:3px solid #333333; padding-bottom:8px; ">
          <a style="font-weight: bold;">全部</a>
        </span>
        <a>影片</a>
        <a>播放清單</a>
        <a>用戶</a>
      </div>

    </div>
  </div>
</nav>
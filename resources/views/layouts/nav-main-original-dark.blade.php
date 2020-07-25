<nav id="hentai-main-nav">
  <div class="container-fluid">
    <div style="height: 65px;">

      <span id="hentai-menu-btn" class="pull-left nav-item-icon no-select">
        <span class="material-icons">menu</span>
      </span>

      <a id="hentai-logo" class="pull-left" href="/">
          <img src="https://i.imgur.com/VFVJg5f.png">
      </a>

      <form id="search-form" class="hidden-xs hidden-sm pull-left" style="width: 50%; margin-top: 13px; left:370px; position: absolute;" action="{{ route('video.search') }}" method="GET">
          <i style="position: absolute; top: 8px; left: 17px; color: dimgray" class="material-icons">search</i>
          <input name="query" style="box-shadow: none; border: 1px solid #404040; background-color: #404040; font-size: 1.1em;border-radius: 3px; height: 40px; padding-left: 53px; color: darkgray; padding-bottom: 2px; font-weight: 500; transition: .3s cubic-bezier(0,0,.2,1);" type="text" value="{{ request('query') }}" placeholder="搜索">
      </form>

      @if (Auth::check())
        <a class="hidden-xs hidden-sm nav-item-icon" style="top: 15px; right: 26px; color: white;" href="{{ route('user.show', Auth::user()) }}"><i class="material-icons">account_circle</i></a>
        <a class="hidden-xs hidden-sm nav-item-icon" style="top: 15px; right: 75px; color: white;" href="{{ route('user.userEditUpload', Auth::user()) }}"><i class="material-icons">video_call</i></a>
      @else
        <a class="no-select nav-item-text hidden-xs hidden-sm" style="top: 15px; color: white; border: 1px solid transparent; padding: 8px 14px; margin-top: 12px; margin-right: 7px; font-weight: bold;" href="{{ route('login') }}">登入</a>
        <a class="no-select nav-item-text hidden-xs hidden-sm" style="top: 15px; color: white; background-color: transparent; border-color: transparent; padding: 7px 14px; margin-top: 12px; font-weight: bold;" href="{{ route('register') }}">註冊</a>
        <a class="no-select pull-right hidden-xs hidden-sm" style="top: 15px; margin-top: 15px; margin-right: 18px;" href="{{ route('login') }}"><i class="material-icons" style="color: white;">video_call</i></a>
      @endif

      <a class="hidden-md hidden-lg nav-item-icon" style="top: 16px; right: 16px; color: white;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="hidden-md hidden-lg nav-item-icon" style="top: 16px; right: 60px; cursor: pointer; color: white;"><i class="material-icons">search</i></a>
      <a id="nav-account-icon" class="pull-right hidden-md hidden-lg nav-item-icon" style="top: 16px; right: 104px; color: white;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i class="material-icons">video_call</i></a>

    </div>
  </div>
</nav>

<nav id="hentai-filter-nav-wrapper" style="background-color: #303030; z-index: 999; padding: 0px 5px; height: 50px; border-bottom: 1px solid rgba(48,48,48,.5); box-shadow: 0 3px 3px -2px rgba(0,0,0,.2),0 3px 4px 0 rgba(0,0,0,.14),0 1px 8px -8px rgba(0,0,0,.12)!important; position: fixed; top: 65px; width: 100%;" class="dark-theme-nav-main">
  <div class="container-fluid" id="hentai-filter-nav">
    <div style="height: 50px;">
      <div class="pull-left" style="color: #d1d1d1">
        <button style="position: relative;" type="button" data-toggle="modal" data-target="#myModal"><span style="vertical-align: middle; color: darkgray;" class="material-icons">loyalty</span><span class="hidden-xs" style="margin-left: 10px">標籤</span><span class="hidden-xs" style="position: absolute; text-align: center; top: 5px; border: 1px solid crimson; border-radius: 50%; background-color: crimson; color: white; line-height: 20px; height: 22px; width: 22px; font-weight: 300; font-size: 0.8em; {{ $tags == [] ? 'display:none;' : '' }}">{{ $tags == [] ? '' : count($tags) }}</span></button>

        <div style="border: 1px solid rgba(58,60,63,.85); line-height: 48px; width: 16vw; text-align: center; display: inline-block; margin-right: 4px"><span style="vertical-align: middle; color: darkgray;" class="material-icons">domain</span><span class="hidden-xs" style="margin-left: 10px">品牌</span></div>
        <div style="border: 1px solid rgba(58,60,63,.85); line-height: 48px; width: 16vw; text-align: center; display: inline-block; margin-right: 4px"><span style="vertical-align: middle; color: darkgray;" class="material-icons">filter_list</span><span class="hidden-xs" style="margin-left: 10px">屏蔽</span></div>
      </div>

      <div class="pull-right" style="color: #d1d1d1">
        <div style="border: 1px solid rgba(58,60,63,.85); line-height: 48px; width: 16vw; text-align: center; display: inline-block; margin-right: 4px"><span style="vertical-align: middle; color: darkgray;" class="material-icons">clear_all</span><span class="hidden-xs" style="margin-left: 10px">重設</span></div>
        <div style="border: 1px solid rgba(58,60,63,.85); line-height: 48px; width: 16vw; text-align: center; display: inline-block; margin-right: 4px"><span style="vertical-align: middle; color: darkgray;" class="material-icons">sort</span><span class="hidden-xs" style="margin-left: 10px">排序</span></div>
      </div>
    </div>
  </div>
</nav>

@include('layouts.nav-search')
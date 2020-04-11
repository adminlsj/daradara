<nav class="nav-main-original {{ $theme == 'dark' ? 'dark-theme-nav-main' : 'white-theme-nav-main' }}">
  <div class="container-fluid">
    <div style="height: 50px;">
      <i id="nav-main-hamburger" class="material-icons hidden-xs hidden-sm">menu</i>

      <a style="text-decoration: none;" href="/">
          <img id="nav-main-logo" src="https://i.imgur.com/{{ $theme == 'dark' ? 'xSMGFWh' : 'M8tqx5K.png'}}.png" height="24" alt="娛見日本 LaughSeeJapan">
      </a>

      @if (Auth::check())
        <a id="nav-account-icon" class="pull-right hidden-xs" style="padding: 0px 0px 0px 15px;" href="{{ route('user.show', Auth::user()) }}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
        <a id="nav-account-icon" class="pull-right hidden-xs" style="padding: 0px 0px 0px 15px;" href="{{ route('user.userEditUpload', Auth::user()) }}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">video_call</i></a>
      @else
        <a class="no-select nav-item-text hidden-xs" style="color: #cf2d52; border: 1px solid #cf2d52; padding: 6px 10px; margin-top: 7px; margin-right: 15px; font-weight: 500" href="{{ route('login') }}">登入</a>
        <a class="no-select nav-item-text hidden-xs" style="color: white; background-color: #cf2d52; padding: 5px 10px; margin-top: 7px; font-weight: 500" href="{{ route('register') }}">註冊</a>
      @endif

      <form id="search-form" class="hidden-xs" style="display: inline-block; margin-top: 9px; text-align: center; width: 62%" action="{{ route('video.search') }}" method="GET">
          <input name="query" style="vertical-align:middle; box-shadow: none; border: 1px solid #d1d1d1; background-color: white; font-size: 1em; width: 62%; border-top-left-radius: 2px; border-bottom-left-radius: 2px; height: 31px; padding-left: 10px;" type="text" value="{{ request('query') }}" placeholder="搜索">
          <a class="search-submit-btn hover-opacity-all" type="submit" style="cursor: pointer;"><i style="font-size: 22px; vertical-align:middle; border: 1px solid #d1d1d1; background-color: #f9f9f9; color: #888888; padding: 3.5px 20px; margin-top: -1px; margin-left: -4px; border-top-right-radius: 2px; border-bottom-right-radius: 2px; border-left: none;" class="material-icons no-select">search</i></a>
      </form>

      <a id="nav-account-icon" class="pull-right hidden-sm hidden-md hidden-lg" style="padding: 0px 0px 0px 15px;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="pull-right hidden-sm hidden-md hidden-lg" style="padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px;" class="material-icons">search</i></a>
      <a id="nav-account-icon" class="pull-right hidden-sm hidden-md hidden-lg" style="padding: 0px 0px 0px 15px;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">video_call</i></a>

    </div>
  </div>
</nav>

@include('layouts.nav-search')

@include('layouts.nav-bottom')
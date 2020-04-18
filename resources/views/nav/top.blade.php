<nav class="nav-main-original white-theme-nav-main">
  <div class="container-fluid">
    <div style="height: 50px;">
      <i id="nav-main-hamburger" class="material-icons hidden-xs hidden-sm" style="margin-top: -6px">menu</i>

      <a style="text-decoration: none;" href="/">
          <span style="font-size: 1.5em; line-height: 47px; margin-left: -4px; color: #d84b6b; letter-spacing: -0.5px; font-weight:500">LaughSeeJapan</span>
      </a>

      @if (Auth::check())
        <a id="nav-account-icon" class="pull-right hidden-xs" style="padding: 0px 0px 0px 15px;" href="{{ route('user.show', Auth::user()) }}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
        <a id="nav-account-icon" class="pull-right hidden-xs" style="padding: 0px 0px 0px 15px;" href="{{ route('user.userEditUpload', Auth::user()) }}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">video_call</i></a>
      @else
        <a class="no-select nav-item-text hidden-xs" style="color: #cf2d52; border: 1px solid #cf2d52; padding: 6px 10px; margin-top: 7px; margin-right: 15px; font-weight: 500" href="{{ route('login') }}">登入</a>
        <a class="no-select nav-item-text hidden-xs" style="color: white; background-color: #cf2d52; padding: 5px 10px; margin-top: 7px; font-weight: 500" href="{{ route('register') }}">註冊</a>
      @endif

      <form id="search-form" class="hidden-xs pull-right" style="text-align: left; width: 62%; margin-top: 10px;" action="{{ route('home.search') }}" method="GET">
          <input name="query" style="box-shadow: none; border: 1px solid #d1d1d1; background-color: white; font-size: 1em; width: 62%; border-top-left-radius: 2px; border-bottom-left-radius: 2px; height: 31px; padding-left: 10px; color: #222222" type="text" value="{{ request('query') }}" placeholder="搜索">
          <a class="search-submit-btn hover-opacity-all" type="submit" style="cursor: pointer;"><i style="font-size: 22px; vertical-align:middle; border: 1px solid #d1d1d1; background-color: #f9f9f9; color: #888888; padding: 3.5px 20px; margin-top: -3px; margin-left: -5px; border-top-right-radius: 2px; border-bottom-right-radius: 2px;" class="material-icons no-select">search</i></a>
      </form>

      <a id="nav-account-icon" class="pull-right hidden-sm hidden-md hidden-lg" style="padding: 0px 0px 0px 15px;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="pull-right hidden-sm hidden-md hidden-lg" style="padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px;" class="material-icons">search</i></a>
      <a id="nav-account-icon" class="pull-right hidden-sm hidden-md hidden-lg" style="padding: 0px 0px 0px 15px;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">video_call</i></a>

    </div>
  </div>
</nav>

@include('nav.top-search')

@include('nav.bottom')
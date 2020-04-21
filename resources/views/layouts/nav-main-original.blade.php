<nav style="border-bottom: 1px solid #e9e9e9; background-color: white; z-index: 999;" class="nav-main-original white-theme-nav-main">
  <div class="container-fluid">
    <div style="height: 50px;">

      <a class="pull-left" style="text-decoration: none; line-height: 50px;" href="/">
          <img id="nav-image" style="height: 22px;" src="https://i.imgur.com/DWGvZ7Y.png">
      </a>

      <form id="search-form" class="hidden-xs hidden-sm pull-left" style="width: 50%; margin-top: 5px; left:370px; position: absolute;" action="{{ route('video.searchGoogle') }}" method="GET">
          <i style="position: absolute; top: 8px; left: 17px; color: dimgray" class="material-icons">search</i>
          <input name="q" style="box-shadow: none; border: 1px solid #e8eaed; background-color: #e8eaed; font-size: 1.1em;border-radius: 7px; height: 40px; padding-left: 53px; color: #222222; padding-bottom: 2px; font-weight: 500;" type="text" value="{{ request('q') }}" placeholder="搜索">
      </form>

      @if (Auth::check())
        <a class="hidden-xs hidden-sm nav-item-icon" style="right: 26px;" href="{{ route('user.show', Auth::user()) }}"><i class="material-icons">account_circle</i></a>
        <a class="hidden-xs hidden-sm nav-item-icon" style="right: 70px;" href="{{ route('user.userEditUpload', Auth::user()) }}"><i class="material-icons">video_call</i></a>
      @else
        <a class="no-select nav-item-text hidden-xs hidden-sm" style="color: #cf2d52; border: 1px solid #cf2d52; padding: 6px 10px; margin-top: 7px; margin-right: 15px; font-weight: 500;" href="{{ route('login') }}">登入</a>
        <a class="no-select nav-item-text hidden-xs hidden-sm" style="color: white; background-color: #cf2d52; padding: 5px 10px; margin-top: 7px; font-weight: 500" href="{{ route('register') }}">註冊</a>
      @endif

      <a class="hidden-md hidden-lg nav-item-icon" style="right: 21px;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="hidden-md hidden-lg nav-item-icon" style="right: 65px; cursor: pointer;"><i class="material-icons">search</i></a>
      <a id="nav-account-icon" class="pull-right hidden-md hidden-lg nav-item-icon" style="right: 109px;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i class="material-icons">video_call</i></a>

    </div>
  </div>
</nav>

@include('layouts.nav-search')

@include('layouts.nav-bottom')
<nav style="background-color: black; z-index: 999; padding: 0px 5px" class="dark-theme-nav-main main">
  <div class="container-fluid">
    <div style="height: 50px;">

      <a class="pull-left" style="text-decoration: none; line-height: 50px;" href="/">
          <img id="nav-image" style="height: 22px;" src="https://i.imgur.com/VFVJg5f.png">
      </a>

      <form id="search-form" class="hidden-xs hidden-sm pull-left" style="width: 50%; margin-top: 5px; left:370px; position: absolute;" action="{{ route('video.search') }}" method="GET">
          <i style="position: absolute; top: 8px; left: 17px; color: dimgray" class="material-icons">search</i>
          <input name="query" style="box-shadow: none; border: 1px solid #262626; background-color: #262626; font-size: 1.1em;border-radius: 7px; height: 40px; padding-left: 53px; color: #222222; padding-bottom: 2px; font-weight: 500;" type="text" value="{{ request('query') }}" placeholder="搜索">
      </form>

      @if (Auth::check())
        <a class="hidden-xs hidden-sm nav-item-icon" style="right: 26px; color: white;" href="{{ route('user.show', Auth::user()) }}"><i class="material-icons">account_circle</i></a>
        <a class="hidden-xs hidden-sm nav-item-icon" style="right: 75px; color: white;" href="{{ route('user.userEditUpload', Auth::user()) }}"><i class="material-icons">video_call</i></a>
      @else
        <a class="no-select nav-item-text hidden-xs hidden-sm" style="color: white; border: 1px solid white; padding: 8px 14px; margin-top: 5px; margin-right: 7px; font-weight: bold;" href="{{ route('login') }}">登入</a>
        <a class="no-select nav-item-text hidden-xs hidden-sm" style="color: black; background-color: white; border-color: white; padding: 7px 14px; margin-top: 5px; font-weight: bold;" href="{{ route('register') }}">註冊</a>
        <a class="no-select pull-right hidden-xs hidden-sm" style="margin-top: 8px; margin-right: 18px;" href="{{ route('login') }}"><i class="material-icons" style="color: white;">video_call</i></a>
      @endif

      <a class="hidden-md hidden-lg nav-item-icon" style="right: 16px; color: white;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="hidden-md hidden-lg nav-item-icon" style="right: 60px; cursor: pointer; color: white;"><i class="material-icons">search</i></a>
      <a id="nav-account-icon" class="pull-right hidden-md hidden-lg nav-item-icon" style="right: 104px; color: white;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i class="material-icons">video_call</i></a>

    </div>
  </div>
</nav>

@include('layouts.nav-search')

@include('layouts.nav-bottom')
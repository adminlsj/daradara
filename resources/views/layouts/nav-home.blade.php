<nav style="background-color: white; z-index: 999;" class="nav-main-original white-theme-nav-main main">
  <div class="container-fluid">
    <div style="height: 50px;">

      <a class="pull-left hidden-md hidden-lg" style="text-decoration: none; line-height: 50px;" href="/">
          <img id="nav-image" style="height: 22px;" src="https://i.imgur.com/DWGvZ7Y.png">
      </a>

      <span id="home-menu-btn" class="pull-left nav-item-icon no-select hidden-xs hidden-sm" style="text-decoration: none; line-height: 50px; margin-top: -1px; left: 23px; color: #666666; cursor: pointer;">
        <span class="material-icons">menu</span>
        <img id="nav-image" style="height: 22px; margin-top: -14px; margin-left: 20px;" src="https://i.imgur.com/DWGvZ7Y.png">
      </span>

      @if (Auth::check())
        <a class="hidden-xs hidden-sm nav-item-icon" style="right: 26px;" href="{{ route('user.show', Auth::user()) }}"><i class="material-icons">account_circle</i></a>
        <a class="hidden-xs hidden-sm nav-item-icon" style="right: 75px;" href="{{ route('user.userEditUpload', Auth::user()) }}"><i class="material-icons">video_call</i></a>
      @else
        <a class="no-select nav-item-text hidden-xs hidden-sm" style="color: #e8eaed; border: 1px solid #e8eaed; padding: 8px 14px; margin-top: 5px; margin-right: 7px; font-weight: bold; color: #666666" href="{{ route('login') }}">登入</a>
        <a class="no-select nav-item-text hidden-xs hidden-sm" style="color: white; background-color: #e8eaed; border-color: #e8eaed; padding: 7px 14px; margin-top: 5px; font-weight: bold; color: #666666;" href="{{ route('register') }}">註冊</a>
        <a class="no-select pull-right hidden-xs hidden-sm" style="margin-top: 8px; margin-right: 18px;" href="{{ route('login') }}"><i class="material-icons">video_call</i></a>
      @endif

      <a class="hidden-md hidden-lg nav-item-icon" style="right: 16px;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="hidden-md hidden-lg nav-item-icon" style="right: 60px; cursor: pointer;"><i class="material-icons">search</i></a>
      <a id="nav-account-icon" class="pull-right hidden-md hidden-lg nav-item-icon" style="right: 104px;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i class="material-icons">video_call</i></a>

    </div>
  </div>
</nav>

@include('layouts.nav-search')

@include('layouts.nav-bottom')
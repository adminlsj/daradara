<nav style="box-shadow: 0 9px 9px -9px rgba(0,0,0,0.1); padding: 0px 10px" class="{{ $theme == 'dark' ? 'dark-theme-nav-main' : 'white-theme-nav-main' }}">
  <div class="container-fluid">
    <div style="height: 50px;">

      <a style="text-decoration: none;" href="/">
          <img src="https://i.imgur.com/SyISzCK.png" style="margin-top:-8px;" height="24" alt="娛見日本 LaughSeeJapan">
          <span class="logo-text" style="font-size: 1.5em; line-height: 46px; padding-left: 2px; letter-spacing: -0.5px;">LaughSeeJapan</span>
      </a>

      <a id="nav-account-icon" class="pull-right" style="padding: 0px 0px 0px 15px;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="pull-right" style="padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </div>
  </div>
</nav>

@include('layouts.nav-search')

@include('layouts.nav-bottom')
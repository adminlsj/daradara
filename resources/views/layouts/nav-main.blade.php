<nav style="box-shadow: 0 9px 9px -9px rgba(0,0,0,0.1); padding: 0px calc(4% - 15px)" class="{{ $theme == 'dark' ? 'dark-theme-nav-main' : 'white-theme-nav-main' }}">
  <div class="container-fluid">
    <div style="height: 50px;">

      <a href="/">
          <img src="{{ $logoImage }}" style="margin-top: 11px;" height="28" alt="娛見日本 LaughSeeJapan">
      </a>

      <a id="nav-account-icon" class="pull-right" style="padding: 0px 0px 0px 15px;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="pull-right" style="padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </div>
  </div>
</nav>

@include('layouts.nav-search')

@include('layouts.nav-bottom')
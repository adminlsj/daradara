<div id="main-nav" style="z-index: 10000 !important; {{ Request::is('*search*') ? 'position: static !important' : '' }}" class="main-nav{{ Request::is('*watch*') || Request::is('*download*') || Request::is('*previews*') ? '-video-show' : '' }} hidden-xs">
  @include('nav.main-content')
</div>

<div id="main-nav-home" style="z-index: 10000; padding:0; padding-top: 3px; height: 48px; line-height: 40px; position: fixed; background-image: none; border-bottom: 1px solid #2b2b2b; margin-bottom: 0px; background-color: #141414;" class="hidden-sm hidden-md hidden-lg">

  <div style="padding: 0 10px; margin-bottom: -10px;">
    <a href="/" style="color: white; font-size: 1.4em; font-family: 'Encode Sans Condensed', sans-serif;">
      <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
    </a>

    <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}">
      <span style="vertical-align: middle; margin-top: -1px;" class="material-icons">account_circle</span>
    </a>

    <a class="nav-icon pull-right" href="{{ route('home.search') }}">
      <img style="margin-top: -2px; margin-right: 1px;" height="20" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/search.png">
    </a>

    <a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}">
      <img style="margin-top: -2px; margin-right: 5px;" height="20" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/notification.png">
    </a>

    <a class="nav-icon pull-right" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}">
      <img style="margin-top: -1px; margin-right: 6px;" height="16" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/preview.png">
    </a>
  </div>
</div>
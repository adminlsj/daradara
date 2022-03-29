<div id="main-nav" style="z-index: 10000 !important; {{ Request::is('*search*') ? 'position: static !important' : '' }}" class="main-nav{{ Request::is('*watch*') || Request::is('*download*') ? '-video-show' : '' }} hidden-xs">
  @include('nav.main-content')
</div>

<div id="main-nav-home" style="z-index: 10000; padding:0; padding-top: 3px; height: 48px; line-height: 40px; position: absolute; background-image: none; border-bottom: 1px solid #383838; margin-bottom: 0px; background-color: #212121;" class="hidden-sm hidden-md hidden-lg">

  <div style="padding: 0 10px; margin-bottom: -10px;">
    <a href="/" style="color: white; font-size: 1.4em; font-family: 'Encode Sans Condensed', sans-serif;">
      <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
    </a>

    <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}">
      <span style="vertical-align: middle; margin-top: -2px;" class="material-icons">account_circle</span>
    </a>

    <a class="nav-icon pull-right" href="{{ route('home.search') }}">
      <img style="margin-top: -3px; margin-right: 1px;" height="20" src="https://i.imgur.com/fblmkmT.png">
    </a>

    <a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}">
      <img style="margin-top: -3px; margin-right: 5px;" height="20" src="https://i.imgur.com/ic0oQVj.png">
    </a>
  </div>
</div>
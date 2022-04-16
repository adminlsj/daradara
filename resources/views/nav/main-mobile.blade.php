<div style="padding: 0 10px; margin-bottom: -10px;">
  <a href="/" style="color: white; font-size: 1.4em; font-family: 'Encode Sans Condensed', sans-serif;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
  </a>

  @if (Auth::check())
    <div id="user-mobile-modal-trigger" style="padding-left: 12px; padding-right: 0px; cursor: pointer;" class="nav-icon pull-right" data-toggle="modal" data-target="#user-mobile-modal">
      <img style="width: 26px; border-radius: 50%;" src="{{ Auth::user()->avatar_temp }}">
    </div>
  @else
    <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}">
      <span style="vertical-align: middle; margin-top: -1px;" class="material-icons">account_circle</span>
    </a>
  @endif

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
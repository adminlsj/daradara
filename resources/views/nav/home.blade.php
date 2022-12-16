<div id="main-nav" style="z-index: 10000 !important; position: relative; height: 85px !important; overflow-x: hidden;" class="main-nav-home hidden-sm hidden-md hidden-lg">
  <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
  </a>

  @if (Auth::check())
    <a id="user-modal-trigger" href="{{ route('home.list') }}" style="padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" >
        <img style="width: 26px; border-radius: 2px;" src="{{ Auth::user()->avatar_temp }}">
    </a>
  @else
      <a style="padding-right: 0px; padding-left: 10px" class="nav-icon pull-right" href="{{ route('login') }}"><span style="vertical-align: middle; font-size: 28px" class="material-icons-outlined">account_circle</span></a>
  @endif

  <a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons-outlined">search</span></a>

  <a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle; font-size: 24px" class="material-icons-outlined">cast</span></a>

  <div style="position: absolute; top: 43px; width: 100%; text-align: center;">
    <div style="display: inline-block; padding: 0 4%; cursor: pointer;"><a href="{{ route('home.search') }}?genre=裏番" style="color: white;">裏番</a></div>
    <div style="display: inline-block; padding: 0 4%; cursor: pointer;"><a href="{{ route('home.search') }}?genre=3D動畫" style="color: white;">3D動畫</a></div>
    <div style="display: inline-block; padding: 0 4%; cursor: pointer;"><a href="{{ route('home.search') }}?genre=同人作品" style="color: white;">同人作品</a></div>
    <div style="display: inline-block; padding: 0 4%; cursor: pointer;"><a style="color: white;" data-toggle="modal" data-target="#genre-modal">全部類型<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 0px;">arrow_drop_down</i></a></div>
  </div>
</div>

<form id="hentai-form" action="{{ route('home.search') }}" method="GET">
  @include('video.modal-genre', ['genre' => ''])
</form>
<div id="main-nav" style="z-index: 10000 !important; position: fixed !important; height: 50px !important; overflow-x: hidden;" class="main-nav-home main-nav-mobile hidden-sm hidden-md hidden-lg">
  <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
  </a>

  @if (Auth::check())
    <a id="user-modal-trigger" href="{{ route('home.list') }}" style="padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" >
        <img style="width: 25px; border-radius: 2px;" src="{{ Auth::user()->avatar_temp }}">
    </a>
  @else
      <a style="padding-right: 0px; padding-left: 7px" class="nav-icon pull-right" href="{{ route('login') }}"><span style="vertical-align: middle; font-size: 28px" class="material-icons-outlined">account_circle</span></a>
  @endif

  <a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons-outlined">search</span></a>

  <a class="nav-icon pull-right" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}"><span style="vertical-align: middle; font-size: 24px" class="material-icons-outlined">cast</span></a>
</div>

<div class="hidden-sm hidden-md hidden-lg hidden-xl" style="position: absolute; top: 50px; width: 100%; text-align: center; z-index: 99; background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0)) !important; height: 40px; line-height: 40px;">
  <div style="display: inline-block; padding: 0 4%; cursor: pointer;"><a href="{{ route('home.search') }}?genre=裏番" style="color: white; text-decoration: none;">裏番</a></div>
  <div style="display: inline-block; padding: 0 4%; cursor: pointer;"><a href="{{ route('home.search') }}?genre=3D動畫" style="color: white; text-decoration: none;">3D動畫</a></div>
  <div style="display: inline-block; padding: 0 4%; cursor: pointer;"><a href="{{ route('home.search') }}?genre=同人作品" style="color: white; text-decoration: none;">同人作品</a></div>
  <div style="display: inline-block; padding: 0 4%; cursor: pointer;"><a style="color: white; text-decoration: none;" data-toggle="modal" data-target="#genre-modal">全部類型<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 0px;">arrow_drop_down</i></a></div>
</div>

<form id="hentai-form" action="{{ route('home.search') }}" method="GET">
  @include('video.modal-genre', ['genre' => ''])
</form>
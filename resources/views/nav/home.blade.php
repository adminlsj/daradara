<div id="main-nav-home-mobile" style="z-index: 10000 !important; position: fixed !important; overflow-x: hidden; background: none; backdrop-filter: blur(20px); transition: height 0.3s; transition: background-color 0.3s" class="hidden-sm hidden-md hidden-lg">

  <div style="padding: 0 15px;">
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

  <div id="sub-nav-home-mobile" class="hidden-sm hidden-md hidden-lg hidden-xl video-buttons-wrapper desktop-inline-mobile-block hide-scrollbar" style="position: absolute; top: 40px; transition: top 0.5s; width: 100%; text-align: center; z-index: 99; height: 40px; line-height: 40px; overflow-y: hidden; padding: 0 15px;">
    <div class="home-genre-tabs-wrapper"><a href="{{ route('home.search') }}?genre=裏番" class="home-genre-tabs" style="text-decoration: none;">裏番</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('home.search') }}?genre=泡麵番" class="home-genre-tabs" style="text-decoration: none;">泡麵番</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('home.search') }}?genre=Motion+Anime" class="home-genre-tabs" style="text-decoration: none;">Motion Anime</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('home.search') }}?genre=3D動畫" class="home-genre-tabs" style="text-decoration: none;">3D動畫</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('home.search') }}?genre=同人作品" class="home-genre-tabs" style="text-decoration: none;">同人作品</a></div>
    <div class="home-genre-tabs-wrapper"><a href="https://l.erodatalabs.com/s/0CxEQ4" class="home-genre-tabs" style="text-decoration: none;" target="_blank">無碼黃油</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('home.search') }}?genre=Cosplay" class="home-genre-tabs" style="text-decoration: none;">Cosplay</a></div>
    <div class="home-genre-tabs-wrapper"><a href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}" class="home-genre-tabs" style="text-decoration: none;">新番預告</a></div>
    <div class="home-genre-tabs-wrapper" style="margin-right: 0px;"><a href="{{ route('comic.index') }}" class="home-genre-tabs" style="text-decoration: none;">H漫畫</a></div>
  </div>
</div>

<form id="hentai-form" action="{{ route('home.search') }}" method="GET">
  @include('video.modal-genre', ['genre' => ''])
</form>
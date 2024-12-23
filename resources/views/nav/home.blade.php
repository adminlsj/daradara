<div id="main-nav-home-mobile" style="z-index: 10000 !important; position: fixed !important; overflow-x: hidden; background: none; transition: height 0.3s, background-color 0.4s, backdrop-filter 0.4s, -webkit-backdrop-filter 0.4s, top 0.4s;" class="hidden-sm hidden-md hidden-lg nav-slide-on-scroll nav-trans-on-scroll">

  <div style="padding: 0 15px;">
    <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.40em; line-height: 57px; margin-left: 5px;">
      <img style="width: 15px; margin-top: -7px; margin-right: 2px;" src="https://vdownload.hembed.com/image/icon/nav_logo.png?secure=HxkFdqiVxMMXXjau9riwGg==,4855471889">
    </a>

    @if (Auth::check())
      <a id="user-modal-trigger" href="{{ route('anime.search') }}" style="padding-left: 1px; padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" >
          <img style="width: 24px; border-radius: 2px;" src="{{ Auth::user()->avatar_temp }}">
      </a>
    @else
      <a id="user-modal-trigger" href="{{ route('login') }}" style="padding-left: 1px; padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" >
          <img style="width: 24px; border-radius: 2px;" src="https://vdownload.hembed.com/image/icon/user_default_image.jpg?secure=ue9M119kdZxHcZqDPrunLQ==,4855471320">
      </a>
    @endif

    <a style="margin-top: -1px; padding: 0 11px;" class="nav-icon pull-right" href="{{ route('anime.search') }}"><img style="width: 31px;" src="https://vdownload.hembed.com/image/icon/search_input_placeholder.png?secure=10N-U1uEz-5YMgWwuLCfPw==,4855472065"></a>

    <a style="padding: 0 10px;" class="nav-icon pull-right" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}"><span style="vertical-align: middle; font-size: 24px" class="material-icons-outlined">cast</span></a>
  </div>

  <div id="sub-nav-home-mobile" class="hidden-sm hidden-md hidden-lg hidden-xl video-buttons-wrapper desktop-inline-mobile-block hide-scrollbar" style="position: absolute; top: 40px; transition: top 0.5s; width: 100%; text-align: center; z-index: 99; height: 40px; line-height: 40px; overflow-y: hidden; padding: 0 15px;">
    <div class="home-genre-tabs-wrapper"><a href="{{ route('anime.search') }}?genre=裏番" class="home-genre-tabs" style="text-decoration: none;">裏番</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('anime.search') }}?genre=泡麵番" class="home-genre-tabs" style="text-decoration: none;">泡麵番</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('anime.search') }}?genre=Motion+Anime" class="home-genre-tabs" style="text-decoration: none;">Motion Anime</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('anime.search') }}?genre=3D動畫" class="home-genre-tabs" style="text-decoration: none;">3D動畫</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('anime.search') }}?genre=同人作品" class="home-genre-tabs" style="text-decoration: none;">同人作品</a></div>
    <div class="home-genre-tabs-wrapper"><a href="https://l.labsda.com/s/0ZIRw4" class="home-genre-tabs" style="text-decoration: none;" target="_blank">無碼黃油</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('anime.search') }}?genre=MMD" class="home-genre-tabs" style="text-decoration: none;">MMD</a></div>
    <div class="home-genre-tabs-wrapper"><a href="{{ route('anime.search') }}?genre=Cosplay" class="home-genre-tabs" style="text-decoration: none;">Cosplay</a></div>
    <div class="home-genre-tabs-wrapper"><a href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}" class="home-genre-tabs" style="text-decoration: none;">新番預告</a></div>
  </div>
</div>

<form id="hentai-form" action="{{ route('anime.search') }}" method="GET">
  @include('anime.search.modal-genre', ['genre' => ''])
</form>
<div id="main-nav-home" style="z-index: 10000; padding:0; padding-top: 3px; height: 48px; line-height: 40px; position: absolute; background-image: none; border-bottom: 1px solid #2b2b2b; margin-bottom: 0px; background-color: #141414;" class="hidden-sm hidden-md hidden-lg">

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

  <div class="hide-scrollbar nav-mobile-genres" style="overflow-x: scroll; width: calc(100%); display: inline-block; white-space: nowrap; margin-bottom: -10px; line-height: 31px; position: absolute; top: 48px; border-radius: 0px; padding-top: 9px; padding-bottom: 8px; border-bottom: 1px solid #2b2b2b; background-color: #141414;">

    <div style="border-right: 1px solid #2b2b2b; display: inline-block; margin-right: 7px;">
      <a style="color: white; margin-right: 11px; margin-left: 10px; background-color: #2b2b2b; padding: 7px 13px 7px 8px; border-radius: 2px; font-weight: bold" href="{{ route('home.search') }}?query=&genre=全部&sort=他們在看">
        <img style="margin-top: -3px; margin-right: 6px;" height="20" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/explore.png">探索
      </a>
    </div>

    <!-- <a class="nav-home-mobile-button" href="/" style="background-color: #FFFFFF; color: black; border-color: white;">主頁</a> -->
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=裏番&duration=&sort=&query=&year=&month=">裏番</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=泡麵番&duration=&sort=&query=&year=&month=">泡麵番</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=3D動畫&duration=&sort=&query=&year=&month=">3D動畫</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=同人作品&duration=&sort=&query=&year=&month=">同人作品</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">Cosplay</a>
    <a class="nav-home-mobile-button" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}">新番預告</a>
    <a class="nav-home-mobile-button" href="{{ route('comic.index') }}" style="margin-right: 10px;">H漫畫</a>
  </div>

  <script>
      var targetOffset = $(".nav-mobile-genres").offset().top;
      var $window = $(window).scroll(function(){
          if ( $window.scrollTop() > 48 ) {   
            $(".nav-mobile-genres").css({"position":"fixed", 'top':'0px'});
          } else {
            $(".nav-mobile-genres").css({"position":"absolute", 'top':'48px'});
          }
      });
    </script>
</div>

@if (Auth::check())
  <div style="z-index: 10001" id="user-mobile-modal" class="modal" role="dialog">
    <div class="modal-dialog modal-sm" style="position: absolute; top: 87px;">
      <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
        <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
          <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
          <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">帳戶設定</h4>
        </div>

        <div class="modal-body" style="padding: 0; height: calc(100% - 65px); overflow-x: hidden;">
          @include('layouts.user-modal-content')
          <hr style="margin: 0; border-color: #333333;">
        </div>
      </div>
    </div>
  </div>
@endif
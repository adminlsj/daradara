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

  <div class="hide-scrollbar nav-mobile-genres" style="overflow-x: scroll; width: calc(100%); display: inline-block; white-space: nowrap; margin-bottom: -10px; line-height: 31px; position: absolute; top: 48px; border-radius: 0px; padding-top: 9px; padding-bottom: 8px; border-bottom: 1px solid #383838; background-color: #212121;">

    <div style="border-right: 1px solid #383838; display: inline-block; margin-right: 6px;">
      <a style="color: white; margin-right: 11px; margin-left: 10px; background-color: #373737; padding: 7px 13px 7px 8px; border-radius: 2px; font-weight: bold" href="{{ route('home.search') }}?genre=裏番&tags%5B%5D=新番預告&sort=">
        <img style="margin-top: -3px; margin-right: 6px;" height="20" src="https://i.imgur.com/H7gRtRi.png">探索
      </a>
    </div>

    <a class="nav-home-mobile-button" href="/" style="background-color: #FFFFFF; color: black; border-color: white;">主頁</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=裏番&duration=&sort=&query=&year=&month=">裏番</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=泡麵番&duration=&sort=&query=&year=&month=">泡麵番</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=3D動畫&duration=&sort=&query=&year=&month=">3D動畫</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=同人作品&duration=&sort=&query=&year=&month=">同人作品</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">Cosplay</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=裏番&tags%5B%5D=新番預告&sort=">新番預告</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=" style="margin-right: 10px;">H漫畫</a>
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
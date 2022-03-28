<div id="main-nav-home" style="z-index: 10000; padding:0; padding-top: 3px; height: 47px; line-height: 40px; position: absolute; background-image: none; border-bottom: 1px solid #383838; margin-bottom: 0px; background-color: #212121;" class="hidden-sm hidden-md hidden-lg">

  <div style="padding: 0 15px; margin-bottom: -10px;">
    <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em; font-family: Righteous;">
      <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
    </a>

    <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}">
      <span style="vertical-align: middle;" class="material-icons-outlined">account_circle</span>
    </a>

    <a class="nav-icon pull-right" href="{{ route('home.search') }}">
      <span style="vertical-align: middle;" class="material-icons-outlined">search</span>
    </a>

    <a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}">
      <span style="vertical-align: middle;" class="material-icons-outlined">video_call</span>
    </a>
  </div>

  <div class="hide-scrollbar nav-mobile-genres" style="overflow-x: scroll; width: calc(100%); display: inline-block; white-space: nowrap; margin-bottom: -10px; line-height: 31px; position: absolute; top: 47px; border-radius: 0px; padding-top: 8px; padding-bottom: 8px; border-bottom: 1px solid #383838; background-color: #212121;">

    <div style="border-right: 1px solid #383838; display: inline-block; margin-right: 6px;">
      <a style="color: white; margin-right: 11px; margin-left: 10px; background-color: #373737; padding: 7px 12px 7px 6px; border-radius: 3px; font-weight: bold" href="{{ route('home.search') }}?genre=H動漫&tags%5B%5D=新番預告&sort=">
        <span style="vertical-align: middle; margin-top: -2px; font-size: 23px; margin-right: 4px;" class="material-icons-outlined">explore</span>探索
      </a>
    </div>

    <a class="nav-home-mobile-button" href="/" style="background-color: #FFFFFF; color: black; border-color: white;">主頁</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">裏番</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">泡麵番</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=3D動畫&duration=&sort=&query=&year=&month=">3D</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=同人作品&duration=&sort=&query=&year=&month=">同人</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">COS</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=H動漫&tags%5B%5D=新番預告&sort=">預告</a>
    <a class="nav-home-mobile-button" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=" style="margin-right: 10px;">漫畫</a>
  </div>

  <!-- <div class="hide-scrollbar nav-mobile-genres" style="overflow-x: scroll; width: calc(100%); display: inline-block; white-space: nowrap; margin-bottom: -10px; line-height: 31px; position: absolute; top: 53px; border-radius: 0px; padding-top: 5px; padding-bottom: 5px;">
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 18px; padding-left: 15px" href="{{ route('home.search') }}?genre=H動漫&tags%5B%5D=新番預告&sort=">預告</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 18px; font-weight: bold;border-bottom: 2px solid crimson; color: crimson; padding-bottom: 10px; padding-left: 2px; padding-right: 2px;" href="/">主頁</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">裏番</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">泡麵番</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=3D動畫&duration=&sort=&query=&year=&month=">3D</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=同人作品&duration=&sort=&query=&year=&month=">同人</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">COS</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 15px" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">漫畫</a>
  </div> -->

  <script>
      var targetOffset = $(".nav-mobile-genres").offset().top;
      var $window = $(window).scroll(function(){
          if ( $window.scrollTop() > 47 ) {   
            $(".nav-mobile-genres").css({"position":"fixed", 'top':'0px'});
          } else {
            $(".nav-mobile-genres").css({"position":"absolute", 'top':'47px'});
          }
      });
    </script>
</div>
<div id="main-nav-home" style="z-index: 10000000; padding:0; padding-top: 5px; height: 55px; line-height: 47px; position: absolute; background-color: transparent; background-color: black;" class="hidden-sm hidden-md hidden-lg">

  <div style="padding: 0 15px; margin-bottom: -10px;">
    <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
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

  <div class="hide-scrollbar nav-mobile-genres" style="overflow-x: scroll; width: calc(100%); display: inline-block; white-space: nowrap; margin-bottom: -10px; line-height: 31px; position: absolute; top: 55px; background-color: black; border-radius: 3px; box-shadow: 1px 1px 1px 0 rgba(40, 40, 40, 0.6); padding-bottom: 5px; border-radius: 0px;">
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 18px; padding-left: 15px" href="{{ route('home.search') }}?genre=H動漫&tags%5B%5D=新番預告&sort=">預告</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 18px; font-weight: bold;border-bottom: 2px solid crimson; color: crimson; padding-bottom: 10px; padding-left: 2px; padding-right: 2px;" href="/">主頁</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">裏番</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">泡麵番</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=3D動畫&duration=&sort=&query=&year=&month=">3D</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=同人作品&duration=&sort=&query=&year=&month=">同人</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 20px" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">COS</a>
    <a style="color: white; font-weight: normal; font-family: 'Trebuchet MS', sans-serif; margin-right: 15px" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">漫畫</a>
  </div>

  <script>
      var targetOffset = $(".nav-mobile-genres").offset().top;
      var $window = $(window).scroll(function(){
          if ( $window.scrollTop() > 55 ) {   
            $(".nav-mobile-genres").css({"position":"fixed", 'top':'0px'});
          } else {
            $(".nav-mobile-genres").css({"position":"absolute", 'top':'55px'});
          }
      });
    </script>
</div>
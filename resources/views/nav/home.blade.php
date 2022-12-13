<div id="main-nav" style="z-index: 10000 !important; position: relative; height: 85px !important;" class="main-nav-home hidden-sm hidden-md hidden-lg">
  <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
  </a>
  <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}"><span style="vertical-align: middle;" class="material-icons-outlined">account_circle</span></a>
  <a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons-outlined">search</span></a>
  <a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle;" class="material-icons-outlined">video_call</span></a>

  <div style="position: absolute; top: 43px; width: 100%; text-align: center;">
    <div style="display: inline-block; padding: 0 4%"><a style="color: white;">裏番</a></div>
    <div style="display: inline-block; padding: 0 4%"><a style="color: white;">3D動畫</a></div>
    <div style="display: inline-block; padding: 0 4%"><a style="color: white;">同人作品</a></div>
    <div style="display: inline-block; padding: 0 4%"><a style="color: white;">全部類型<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 0px;">arrow_drop_down</i></a></div>
  </div>
</div>
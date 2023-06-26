<div id="main-nav" style="z-index: 10000 !important; {{ Request::is('*search*') ? 'position: static !important' : '' }}" class="main-nav{{ Request::is('*watch*') || Request::is('*download*') || Request::is('*previews*') ? '-video-show' : '' }} hidden-xs">
  @include('jav.nav-main-content')
</div>

<div id="main-nav-home" style="z-index: 10001; padding:0; padding-top: 3px; height: 48px; line-height: 40px; position: fixed; background-image: none; border-bottom: 1px solid #2b2b2b; margin-bottom: 0px; background-color: #141414;" class="hidden-sm hidden-md hidden-lg">
  @include('jav.nav-main-mobile')
</div>
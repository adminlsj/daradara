<div id="main-nav" style="z-index: 10000 !important; {{ Request::is('*search*') ? 'position: static !important' : '' }}" class="main-nav{{ Request::is('*watch*') || Request::is('*download*') || Request::is('*previews*') ? '-video-show' : '' }} hidden-xs">
  @include('nav.main-content')
</div>

<div id="main-nav-home" style="z-index: 10001; padding:0; height: 53px; line-height: 53px; position: fixed; background-image: none;  background-color: #141414;" class="hidden-sm hidden-md hidden-lg">
  @include('nav.main-mobile')
</div>
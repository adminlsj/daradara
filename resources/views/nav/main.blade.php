<div id="main-nav" style="z-index: 10000 !important; {{ Request::is('*search*') || Request::is('g/*') ? 'position: static !important' : '' }}" class="main-nav{{ Request::is('*watch*') || Request::is('*download*') ? '-video-show' : '' }}">
  @include('nav.main-content')
</div>
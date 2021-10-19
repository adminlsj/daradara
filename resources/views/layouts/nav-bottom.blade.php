<div style="z-index: 10000 !important; border-top: 1px solid #222222; {{ Request::is('*watch*') ? 'display:none;' : '' }}" class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/">
    @if (Request::is('/'))
      <i style="font-size: 30px; margin-top: 9px; color: white" class="material-icons">home</i>
    @else
      <i style="font-size: 30px; margin-top: 9px;" class="material-icons-outlined">home</i>
    @endif
  </a>
  <a href="{{ route('home.search') }}">
    @if (Request::is('*search'))
      <i style="font-size: 32px; margin-top: 8px; color: white;" class="material-icons">search</i>
    @else
      <i style="font-size: 32px; margin-top: 8px;" class="material-icons">search</i>
    @endif
  </a>
  <a href="{{ Auth::check() ? route('home.list') : route('login') }}">
    @if (Request::is('*list*'))
      <i style="font-size: 27px; margin-top: 10px; color: white" class="material-icons">subscriptions</i>
    @else
      <i style="font-size: 27px; margin-top: 10px;" class="material-icons-outlined">subscriptions</i>
    @endif
  </a>
  <a href="{{ route('home.search') }}?query=&sort=本日排行">
    @if (Request::is('*rank*'))
      <i style="padding-left: 0px; font-size: 30px; margin-top: 8px;" class="material-icons{{ Request::is('*rank*') ? '' : '-outlined' }}">whatshot</i>
    @else
      <i style="padding-left: 0px; font-size: 30px; margin-top: 9px;" class="material-icons{{ Request::is('*rank*') ? '' : '-outlined' }}">whatshot</i>
    @endif
  </a>
  <a href="{{ route('home.search') }}">
    @if (Request::is('*newest*'))
      <i style="padding-left: 2px; font-size: 31px; margin-top: 8px" class="material-icons{{ Request::is('*newest*') ? '' : '-outlined' }}">menu</i>
    @else
      <i style="padding-left: 2px; font-size: 31px; margin-top: 9px" class="material-icons{{ Request::is('*newest*') ? '' : '-outlined' }}">menu</i>
    @endif
  </a>
</div>
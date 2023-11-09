<div style="z-index: 10000 !important; background-color: rgba(30,30,30,0.75); backdrop-filter: blur(40px); -webkit-backdrop-filter: blur(40px); {{ Request::is('*watch*') ? 'display:none;' : '' }}" class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/">
    @if (Request::is('/'))
      <img style="height: 19px; margin-top: 8px;" src="https://pbs.twimg.com/media/F-UXvmXaUAA2U1E?format=png&name=120x120">
      <div style="font-size: 9px; color: white; margin-top: 5px;">主頁</div>
    @else
      <img style="height: 19px; margin-top: 8px;" src="https://pbs.twimg.com/media/F-UY9HGbwAAOBEH?format=png&name=120x120">
      <div style="font-size: 9px; color: #838383; margin-top: 5px;">主頁</div>
    @endif
  </a>
  <a href="{{ route('home.search') }}?sort=本日排行">
    @if (Request::getRequestUri() == '/search?sort=%E6%9C%AC%E6%97%A5%E6%8E%92%E8%A1%8C')
      <img style="height: 21px; margin-top: 7px;" src="https://i.imgur.com/WsWXk9S.png">
      <div style="font-size: 9px; color: white; margin-top: 4px;">本日排行</div>
    @else
      <img style="height: 21px; margin-top: 7px;" src="https://i.imgur.com/icBuruf.png">
      <div style="font-size: 9px; color: #838383; margin-top: 4px;">本日排行</div>
    @endif
  </a>
  <a href="{{ Auth::check() ? route('playlist.index') : route('login') }}">
    @if (Request::is('*playlists*'))
      <img style="height: 22px; margin-top: 7px; border-radius: 2px;" src="{{ Auth::check() ? Auth::user()->avatar_temp : 'https://pbs.twimg.com/media/F-URvjzbUAAVmKM?format=jpg&name=240x240' }}">
      <div style="font-size: 9px; color: white; margin-top: 3px;">我的 Hanime1</div>
    @else
      <img style="height: 22px; margin-top: 7px; border-radius: 2px;" src="{{ Auth::check() ? Auth::user()->avatar_temp : 'https://pbs.twimg.com/media/F-URvjzbUAAVmKM?format=jpg&name=240x240' }}">
      <div style="font-size: 9px; color: #838383; margin-top: 3px;">我的 Hanime1</div>
    @endif
  </a>
</div>
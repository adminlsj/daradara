<div style="z-index: 10000 !important; background-color: rgba(30,30,30,0.75); backdrop-filter: blur(40px); -webkit-backdrop-filter: blur(40px); {{ Request::is('*watch*') ? 'display:none;' : '' }}" class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/">
    @if (Request::is('/'))
      <img style="height: 19px; margin-top: 8px;" src="https://vdownload.hembed.com/image/icon/home_bottom_filled.png?secure=VMuej-azpssSTsI6qbutMw==,4855471126">
      <div style="font-size: 9px; color: white; margin-top: 5px;">主頁</div>
    @else
      <img style="height: 19px; margin-top: 8px;" src="https://vdownload.hembed.com/image/icon/home_bottom.png?secure=w_Q89cksdp0h226Avn6zNg==,4855471146">
      <div style="font-size: 9px; color: #838383; margin-top: 5px;">主頁</div>
    @endif
  </a>

  <a href="{{ route('anime.search') }}?sort=本日排行">
    @if (Request::getRequestUri() == '/search?sort=%E6%9C%AC%E6%97%A5%E6%8E%92%E8%A1%8C')
      <img style="height: 21px; margin-top: 7px;" src="https://vdownload.hembed.com/image/icon/today_ranking_filled.png?secure=kDlxk3B3EM97kAmjk4FD5A==,4855470957">
      <div style="font-size: 9px; color: white; margin-top: 4px;">本日排行</div>
    @else
      <img style="height: 21px; margin-top: 7px;" src="https://vdownload.hembed.com/image/icon/today_ranking.png?secure=WzptRxvZ-UwMjikXws-A5A==,4855471035">
      <div style="font-size: 9px; color: #838383; margin-top: 4px;">本日排行</div>
    @endif
  </a>

  <a href="{{ route('anime.search') }}">
    @if (Request::is('*subscriptions*'))
      <img style="height: 24px; margin-top: 5px; filter: brightness(200%);" src="https://vdownload.hembed.com/image/icon/subscriptions_fill.png?secure=AwTMLCGvKnqo_uYr0kwGlA==,4878116956">
      <div style="font-size: 9px; color: white; margin-top: 3px;">訂閱內容</div>
    @else
      <img style="height: 24px; margin-top: 5px;" src="https://vdownload.hembed.com/image/icon/subscriptions.png?secure=9BHOti1nrGPhhhngzCZaRQ==,4878116575">
      <div style="font-size: 9px; color: #838383; margin-top: 3px;">訂閱內容</div>
    @endif
  </a>

  <a href="{{ Auth::check() ? route('anime.search') : route('login') }}">
    @if (Request::is('*playlists*'))
      <img style="height: 22px; margin-top: 7px; border-radius: 2px;" src="{{ Auth::check() ? Auth::user()->avatar_temp : 'https://vdownload.hembed.com/image/icon/user_default_image.jpg?secure=ue9M119kdZxHcZqDPrunLQ==,4855471320' }}">
      <div style="font-size: 9px; color: white; margin-top: 3px;">我的 Hanime1</div>
    @else
      <img style="height: 22px; margin-top: 7px; border-radius: 2px;" src="{{ Auth::check() ? Auth::user()->avatar_temp : 'https://vdownload.hembed.com/image/icon/user_default_image.jpg?secure=ue9M119kdZxHcZqDPrunLQ==,4855471320' }}">
      <div style="font-size: 9px; color: #838383; margin-top: 3px;">我的 Hanime1</div>
    @endif
  </a>
</div>
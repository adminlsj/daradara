<div style="z-index: 10000 !important; background-color: #edf1f5; border-top: 1px solid rgba(221, 230, 238, 0.6)" class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/" style="color: #5c728a;">
    @if (Request::is('/'))
      <img style="height: 22px; margin-top: 7px;" src="https://images2.imgbox.com/a1/39/dGzAzEb1_o.png">
      <div style="font-size: 9px; margin-top: 3px;">主頁</div>
    @else
      <img style="height: 22px; margin-top: 7px;" src="https://images2.imgbox.com/a3/43/OwM5qFGZ_o.png">
      <div style="font-size: 9px; margin-top: 3px;">主頁</div>
    @endif
  </a>

  <a href="{{ route('preview.show', ['season' => 'Winter', 'year' => 2025]) }}" style="color: #5c728a;">
    @if (Request::is('*preview*'))
      <img style="height: 21px; margin-top: 7px;" src="https://images2.imgbox.com/ef/8b/IiDdEvLV_o.png">
      <div style="font-size: 9px; margin-top: 4px;">新番預告</div>
    @else
      <img style="height: 21px; margin-top: 7px;" src="https://images2.imgbox.com/71/ca/71QRtoGb_o.png">
      <div style="font-size: 9px; margin-top: 4px;">新番預告</div>
    @endif
  </a>

  <a href="{{ route('anime.search') }}" style="color: #5c728a;">
    @if (Request::is('*anime/search*'))
      <img style="height: 24px; margin-top: 5px;" src="https://images2.imgbox.com/03/ae/xyQJpnO8_o.png">
      <div style="font-size: 9px; margin-top: 3px;">搜尋</div>
    @else
      <img style="height: 24px; margin-top: 5px;" src="https://images2.imgbox.com/d0/ba/vOy6l41S_o.png">
      <div style="font-size: 9px; margin-top: 3px;">搜尋</div>
    @endif
  </a>

  <a href="{{ route('anime.search') }}?sort=本日排行" style="color: #5c728a;">
    @if (Request::getRequestUri() == '/search?sort=%E6%9C%AC%E6%97%A5%E6%8E%92%E8%A1%8C')
      <img style="height: 21px; margin-top: 7px;" src="https://images2.imgbox.com/2d/2f/omEUBRbL_o.png">
      <div style="font-size: 9px; margin-top: 4px;">通知</div>
    @else
      <img style="height: 21px; margin-top: 7px;" src="https://images2.imgbox.com/81/b4/mBL5Fanh_o.png">
      <div style="font-size: 9px; margin-top: 4px;">通知</div>
    @endif
  </a>

  <a href="{{ Auth::check() ? route('user.animelist', ['user' => Auth::user(), 'name' => Auth::user()->name]) : route('login') }}" style="color: #5c728a;">
    @if (Request::is('*playlists*'))
      <img style="height: 19px; margin-top: 7px; border-radius: 2px;" src="{{ Auth::check() ? Auth::user()->avatar_temp : 'https://images2.imgbox.com/5f/2b/uPIwZSoy_o.jpg' }}">
      <div style="font-size: 9px; margin-top: 6px;">我的清單</div>
    @else
      <img style="height: 19px; margin-top: 7px; border-radius: 2px;" src="{{ Auth::check() ? Auth::user()->avatar_temp : 'https://images2.imgbox.com/5f/2b/uPIwZSoy_o.jpg' }}">
      <div style="font-size: 9px; margin-top: 6px;">我的清單</div>
    @endif
  </a>
</div>
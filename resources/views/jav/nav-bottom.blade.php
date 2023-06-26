<div style="z-index: 10000 !important; border-top: 1px solid #222222; {{ Request::is('*watch*') ? 'display:none;' : '' }}" class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/jav">
    @if (Request::is('jav'))
      <img style="height: 18px; margin-top: 8px;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@v2.0.0/asset/icon/home-filled.png">
      <div style="font-size: 9px; color: white; margin-top: 4px;">主頁</div>
    @else
      <img style="height: 18px; margin-top: 8px;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@v2.0.0/asset/icon/home.png">
      <div style="font-size: 9px; color: white; margin-top: 4px;">主頁</div>
    @endif
  </a>
  <a href="{{ route('jav.search') }}">
    <img style="height: 18px; margin-top: 8px;" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/search.png">
    <div style="font-size: 9px; color: white; margin-top: 4px;">搜索</div>
  </a>
  <a href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}">
    <img style="height: 33px; margin-top: 5px;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@v2.0.0/asset/icon/create.png">
  </a>
  <a href="{{ route('playlist.index') }}">
    @if (Request::is('*playlists*'))
      <img style="height: 18px; margin-top: 8px;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@v2.0.0/asset/icon/playlist-filled.png">
      <div style="font-size: 9px; color: white; margin-top: 4px;">我的清單</div>
    @else
      <img style="height: 18px; margin-top: 8px;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@v2.0.0/asset/icon/playlist.png">
      <div style="font-size: 9px; color: white; margin-top: 4px;">我的清單</div>
    @endif
  </a>
  <a style="cursor: pointer;" data-toggle="modal" data-target="#links-modal">
    <img style="height: 18px; margin-top: 8px;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@v2.0.0/asset/icon/genre.png">
    <div style="font-size: 9px; color: white; margin-top: 4px;">全部分類</div>
  </a>
</div>

<div id="links-modal" class="modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
        <h4 class="modal-title">全部分類</h4>
      </div>

      <div class="modal-body" style="padding: 0; height: calc(100% - 65px); overflow-x: hidden;">
        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="{{ route('jav.search') }}?genre=日本AV">
              <div class="simple-dropdown-item genre-option">日本AV</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="{{ route('jav.search') }}?genre=素人業餘">
              <div class="simple-dropdown-item genre-option">素人業餘</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="{{ route('jav.search') }}?genre=高清無碼">
              <div class="simple-dropdown-item genre-option">高清無碼</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="{{ route('jav.search') }}?genre=AI解碼">
              <div class="simple-dropdown-item genre-option">AI解碼</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="{{ route('jav.search') }}?genre=國產AV">
              <div class="simple-dropdown-item genre-option">國產AV</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="{{ route('jav.search') }}?genre=國產素人">
              <div class="simple-dropdown-item genre-option">國產素人</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="{{ route('jav.search') }}?tags%5B%5D=中文字幕">
              <div class="simple-dropdown-item">中文字幕</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="https://discord.gg/WWYc9m9CUQ" target="_blank">
              <div class="simple-dropdown-item">Discord</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">
        
        <div class="modal-header" style="border-bottom: 1px solid #333333; height: 65px;">
          <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">友情鏈結</h4>
        </div>

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="https://theporndude.com/zh" target="_blank">
              <div class="simple-dropdown-item">PornDude</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="https://qingse.one" target="_blank">
              <div class="simple-dropdown-item">情色網站大全</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="https://141jj.com/" target="_blank">
              <div class="simple-dropdown-item">141JJ 導航</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="http://www.pornbest.org/" target="_blank">
              <div class="simple-dropdown-item">PornBest 中字</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="/" target="_blank">
              <div class="simple-dropdown-item">Hanime1 H動漫</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="https://share.acgnx.net/" target="_blank">
              <div class="simple-dropdown-item">末日動漫資源庫</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="https://moeli-desu.com/" target="_blank">
              <div class="simple-dropdown-item">夢璃</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="https://www.sshs.pw/" target="_blank">
              <div class="simple-dropdown-item">紳士會所</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">
      </div>
    </div>
  </div>
</div>
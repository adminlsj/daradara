<div style="z-index: 10000 !important; background-color: rgba(30,30,30,0.7); backdrop-filter: blur(45px); -webkit-backdrop-filter: blur(45px); {{ Request::is('*watch*') ? 'display:none;' : '' }}" class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/">
    @if (Request::is('/'))
      <img style="height: 19px; margin-top: 7px;" src="https://pbs.twimg.com/media/F-UXvmXaUAA2U1E?format=png&name=120x120">
      <div style="font-size: 9px; color: white; margin-top: 4px;">主頁</div>
    @else
      <img style="height: 19px; margin-top: 7px;" src="https://pbs.twimg.com/media/F-UY9HGbwAAOBEH?format=png&name=120x120">
      <div style="font-size: 9px; color: white; margin-top: 4px;">主頁</div>
    @endif
  </a>
  <a href="{{ route('home.search') }}?sort=本日排行">
    <img style="height: 21px; margin-top: 6px;" src="https://i.imgur.com/icBuruf.png">
    <div style="font-size: 9px; color: #838383; margin-top: 4px;">本日排行</div>
  </a>
  <!-- <a href="{{ route('home.search') }}">
    <img style="height: 18px; margin-top: 8px;" src="https://vdownload.hembed.com/image/icon/search.png?secure=F7gupEPkawNuqNqbnFpoFw==,4853042258">
    <div style="font-size: 9px; color: white; margin-top: 4px;">搜索</div>
  </a>
  <a href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}">
    <img style="height: 33px; margin-top: 5px;" src="https://vdownload.hembed.com/image/icon/create.png?secure=32-QfdeAPAWLr1sgZ0ptzQ==,4853050770">
  </a> -->
  <a href="{{ Auth::check() ? route('playlist.index') : route('login') }}">
    @if (Request::is('*playlists*'))
      <img style="height: 22px; margin-top: 6px; border-radius: 2px;" src="{{ Auth::check() ? Auth::user()->avatar_temp : 'https://pbs.twimg.com/media/F-URvjzbUAAVmKM?format=jpg&name=240x240' }}">
      <div style="font-size: 9px; color: white; margin-top: 3px;">我的 Hanime1</div>
    @else
      <img style="height: 22px; margin-top: 6px; border-radius: 2px;" src="{{ Auth::check() ? Auth::user()->avatar_temp : 'https://pbs.twimg.com/media/F-URvjzbUAAVmKM?format=jpg&name=240x240' }}">
      <div style="font-size: 9px; color: #838383; margin-top: 3px;">我的 Hanime1</div>
    @endif
  </a>
  <!-- <a style="cursor: pointer;" data-toggle="modal" data-target="#links-modal">
    <img style="height: 18px; margin-top: 8px;" src="https://vdownload.hembed.com/image/icon/genre.png?secure=riIP7dAAk310OXa9TEva-w==,4853050724">
    <div style="font-size: 9px; color: white; margin-top: 4px;">全部分類</div>
  </a> -->
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
            <a style="color: white; text-decoration: none;" href="{{ route('home.search') }}?genre=裏番">
              <div class="simple-dropdown-item genre-option">裏番</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="{{ route('comic.index') }}">
              <div class="simple-dropdown-item">H漫畫</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}">
              <div class="simple-dropdown-item genre-option">新番預告</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="{{ route('home.search') }}?genre=泡麵番">
              <div class="simple-dropdown-item genre-option">泡麵番</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="{{ route('home.search') }}?genre=3D動畫">
              <div class="simple-dropdown-item genre-option">3D動畫</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="{{ route('home.search') }}?genre=同人作品">
              <div class="simple-dropdown-item genre-option">同人作品</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="{{ route('home.search') }}?genre=Cosplay">
              <div class="simple-dropdown-item genre-option">Cosplay</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="https://l.erodatalabs.com/s/0CxEQ4" target="_blank">
              <div class="simple-dropdown-item">無碼黄油</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

         <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="{{ App\Helper::$discord }}" target="_blank">
              <div class="simple-dropdown-item">Discord</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="{{ App\Helper::$discord }}" target="_blank">
              <div class="simple-dropdown-item">聯絡我們</div>
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
            <a style="color: white; text-decoration: none;" href="{{ route('jav.home') }}" target="_blank">
              <div class="simple-dropdown-item">日本AV 高清中字</div>
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
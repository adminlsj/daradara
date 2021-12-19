<div style="z-index: 10000 !important; border-top: 1px solid #222222; {{ Request::is('*watch*') ? 'display:none;' : '' }}" class="bottom-nav hidden-lg hidden-md white-theme-nav-bottom">
  <a href="/">
    @if (Request::is('/'))
      <i style="font-size: 28px; margin-top: 10px; color: white" class="material-icons">home</i>
    @else
      <i style="font-size: 28px; margin-top: 10px;" class="material-icons-outlined">home</i>
    @endif
  </a>
  <a href="{{ route('home.search') }}">
    <i style="font-size: 30px; margin-top: 9px;" class="material-icons">search</i>
  </a>
  <a href="{{ route('home.search') }}?query=&sort=本日排行">
    <i style="padding-left: 0px; font-size: 29px; margin-top: 9px;" class="material-icons-outlined">whatshot</i>
  </a>
  <a href="{{ Auth::check() ? route('home.list') : route('login') }}">
    @if (Request::is('*list*'))
      <i style="font-size: 26px; margin-top: 11px; color: white" class="material-icons">video_library</i>
    @else
      <i style="font-size: 26px; margin-top: 11px;" class="material-icons-outlined">video_library</i>
    @endif
  </a>
  <a style="cursor: pointer;" data-toggle="modal" data-target="#links-modal">
    <i style="padding-left: 2px; font-size: 29px; margin-top: 10px" class="material-icons">menu</i>
  </a>
</div>

<div id="links-modal" class="modal" role="dialog">
  <div class="modal-dialog modal-sm" style="position: absolute; top: 87px;">
    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">所有分類</h4>
      </div>

      <div class="modal-body" style="padding: 0; height: calc(100% - 65px);">
        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="{{ route('home.search') }}?genre=H動漫">
              <div class="simple-dropdown-item genre-option">H動漫</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="{{ route('comic.index') }}">
              <div class="simple-dropdown-item genre-option">H漫畫</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="{{ route('home.search') }}?genre=H動漫&tags%5B%5D=新番預告">
              <div class="simple-dropdown-item genre-option">新番預告</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="{{ route('home.search') }}?genre=H動漫&tags%5B%5D=番劇">
              <div class="simple-dropdown-item genre-option">番劇</div>
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
            <a style="color: white; text-decoration: none;" href="https://discord.gg/WWYc9m9CUQ" target="_blank">
              <div class="simple-dropdown-item genre-option">Discord</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">
        
        <a style="color: white; text-decoration: none; text-align: center; pointer-events: none;">
          <div class="simple-dropdown-item genre-option">友情鏈結</div>
        </a>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="https://theporndude.com/zh" target="_blank">
              <div class="simple-dropdown-item genre-option">PornDude</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="https://qingse.one" target="_blank">
              <div class="simple-dropdown-item genre-option">情色網站大全</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="https://141jj.com/" target="_blank">
              <div class="simple-dropdown-item genre-option">141JJ 導航</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="http://www.pornbest.org/" target="_blank">
              <div class="simple-dropdown-item genre-option">PornBest 免費中文視頻</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="https://www.17dm.net/" target="_blank">
              <div class="simple-dropdown-item genre-option">妖氣動漫導航</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="https://share.acgnx.net/" target="_blank">
              <div class="simple-dropdown-item genre-option">末日動漫資源庫</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">

        <div class="row" style="text-align: center;">
          <div class="col-xs-6" style="width: 50%; padding-right: 0; border-right: 1px solid #333333;">
            <a style="color: white; text-decoration: none;" href="https://moeli-desu.com/" target="_blank">
              <div class="simple-dropdown-item genre-option">夢璃</div>
            </a>
          </div>
          <div class="col-xs-6" style="width: 50%; padding-left: 0;">
            <a style="color: white; text-decoration: none;" href="https://www.sshs.pw/" target="_blank">
              <div class="simple-dropdown-item genre-option">紳士會所</div>
            </a>
          </div>
        </div>

        <hr style="margin: 0; border-color: #333333;">
      </div>
    </div>
  </div>
</div>
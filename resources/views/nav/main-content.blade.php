<a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=裏番&duration=&sort=&query=&year=&month=">裏番</a>
<a class="nav-item hidden-xs hidden-sm" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}">新番預告</a>
<a class="nav-item hidden-xs hidden-sm" href="{{ route('home.search') }}?genre=泡麵番&duration=&sort=&query=&year=&month=">泡麵番</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=3D動畫&duration=&sort=&query=&year=&month=">3D動畫</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=同人作品&duration=&sort=&query=&year=&month=">同人作品</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">Cosplay</a>
<a class="nav-item hidden-xs" href="{{ route('comic.index') }}">H漫畫</a>
<a class="nav-item hidden-xs hidden-sm" href="https://theporndude.com/zh" target="_blank">PornDude</a>

@if (Auth::check())
    <div id="user-modal-trigger" style="padding-right: 0px; cursor: pointer;" class="nav-icon pull-right" data-toggle="modal" data-target="#user-modal">
        <img style="width: 35px; border-radius: 50%;" src="{{ Auth::user()->avatar_temp }}">
    </div>

    <div id="user-modal" class="modal" role="dialog">
      <div id="user-modal-panel" class="modal-dialog modal-sm" style="position: absolute; {{ Request::is('/') ? 'top: 87px;' : 'top: 30px' }}; right: calc(4% - 1px);">
        <div class="modal-content" style="border-radius: 0px; background-color: #222222; color: white;">
            <div class="no-select" style="border-bottom: solid 1px #333333; padding: 0px 20px 5px 20px">
                <img style="width: 45px; border-radius: 50%; display: inline-block;" src="{{ Auth::user()->avatar_temp }}">
                <div style="display: inline-block; vertical-align: middle; margin-left: 15px;">
                    <h5 style="font-weight: bold;">{{ Auth::user()->name }}</h5>
                    <h5 style="font-size: 12px; color: gray;">加入於 {{ Carbon\Carbon::parse(Auth::user()->created_at)->diffForHumans() }}</h5>
                </div>
            </div>
            <div class="no-select" style="padding: 9px 0px 0px 0px">
                <a class="user-modal-link" href="#">
                    <img src="https://i.imgur.com/NBHKokN.png">
                    <h5>帳戶資料</h5>
                </a>
                <a class="user-modal-link" href="{{ route('home.list') }}">
                    <img src="https://i.imgur.com/DUSbStD.png">
                    <h5>我的清單</h5>
                </a>
                <a class="user-modal-link" href="{{ route('home.list') }}">
                    <img src="https://i.imgur.com/50Mdfbq.png">
                    <h5>稍後觀看</h5>
                </a>
                <a class="user-modal-link" href="#">
                    <img src="https://i.imgur.com/HaqOkM6.png">
                    <h5>語言設定</h5>
                </a>
                <hr style="border-color: #333333; margin: 9px 0px -7px 0px;">
                <form action="{{ route('logout') }}" method="POST">
                    {{ csrf_field() }}
                    <button style="width: 100%; display: inline-block; color: white; vertical-align: middle; text-align: left; margin-bottom: -4px;" class="no-button-style user-modal-link" type="submit">
                        <img style="width: 19px; display: inline-block;" src="https://i.imgur.com/fRde2hY.png">
                        <h5 style="display: inline-block; margin-left: 15px; color: white; vertical-align: middle;">登出</h5>
                    </button>
                </form>
            </div>
        </div>
      </div>
    </div>
@else
    <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}"><span style="vertical-align: middle;" class="material-icons-outlined">account_circle</span></a>
@endif

<a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons-outlined">search</span></a>

<a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle;" class="material-icons-outlined">video_call</span></a>
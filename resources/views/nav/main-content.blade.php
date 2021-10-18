<a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=H動漫&duration=&sort=&query=&year=&month=">H動漫</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=3D動畫&duration=&sort=&query=&year=&month=">3D動畫</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=同人作品&duration=&sort=&query=&year=&month=">同人作品</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">Cosplay</a>
<a class="nav-item hidden-xs" href="{{ route('comic.index') }}">H漫畫</a>
<a class="nav-item hidden-xs hidden-sm" href="{{ route('home.list') }}">我的清單</a>
<a class="nav-item hidden-xs hidden-sm" href="https://theporndude.com/zh" target="_blank">PornDude</a>

<a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}"><span style="vertical-align: middle;" class="material-icons">account_circle</span></a>
<a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons">search</span></a>
<a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle;" class="material-icons">video_call</span></a>
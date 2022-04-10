<a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=裏番&duration=&sort=&query=&year=&month=">裏番</a>
<a class="nav-item hidden-xs hidden-sm" href="{{ route('home.search') }}?genre=裏番&tags%5B%5D=新番預告&sort=">新番預告</a>
<a class="nav-item hidden-xs hidden-sm" href="{{ route('home.search') }}?genre=泡麵番&duration=&sort=&query=&year=&month=">泡麵番</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=3D動畫&duration=&sort=&query=&year=&month=">3D動畫</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=同人作品&duration=&sort=&query=&year=&month=">同人作品</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">Cosplay</a>
<a class="nav-item hidden-xs" href="{{ route('comic.index') }}">H漫畫</a>
<a class="nav-item hidden-xs hidden-sm" href="https://theporndude.com/zh" target="_blank">PornDude</a>

<a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}"><span style="vertical-align: middle;" class="material-icons-outlined">account_circle</span></a>
<a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons-outlined">search</span></a>
<a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle;" class="material-icons-outlined">video_call</span></a>
<a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=裏番&duration=&sort=&query=&year=&month=">裏番</a>
<a class="nav-item hidden-xs" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}">新番預告</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=泡麵番&duration=&sort=&query=&year=&month=">泡麵番</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=3D動畫&duration=&sort=&query=&year=&month=">3D動畫</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=同人作品&duration=&sort=&query=&year=&month=">同人作品</a>
<a class="nav-item hidden-xs" href="{{ route('home.search') }}?genre=Cosplay&duration=&sort=&query=&year=&month=">Cosplay</a>
<a class="nav-item hidden-xs hidden-sm" href="{{ route('comic.index') }}">H漫畫</a>
<a class="nav-item hidden-xs hidden-sm" href="{{ route('playlist.index') }}">我的清單</a>

@if (Auth::check())
    <div id="user-modal-trigger" style="padding-right: 0px; cursor: pointer;" class="nav-icon pull-right" data-toggle="modal" data-target="#user-modal">
        <img style="width: 35px; border-radius: 50%;" src="{{ Auth::user()->avatar_temp }}">
    </div>

    <div id="user-modal" class="modal" role="dialog">
      <div id="user-modal-panel" class="modal-dialog modal-sm" style="position: absolute; {{ Request::is('/') ? 'top: 87px;' : 'top: 30px' }}; right: calc(4% - 1px);">
        <div class="modal-content" style="border-radius: 0px; background-color: #222222; color: white;">
            @include('layouts.user-modal-content')
        </div>
      </div>
    </div>
@else
    <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('login') }}"><span style="vertical-align: middle;" class="material-icons-outlined">account_circle</span></a>
@endif

<a class="nav-icon pull-right" href="{{ route('home.search') }}"><span style="vertical-align: middle;" class="material-icons-outlined">search</span></a>

<a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle;" class="material-icons-outlined">video_call</span></a>
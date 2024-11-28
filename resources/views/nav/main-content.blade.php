<a href="/" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">d</span>aradara<span style="color: crimson">.</span>me
</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == '裏番' ? 'active' : '' }}" href="{{ route('anime.search') }}?genre=裏番">首頁</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == '裏番' ? 'active' : '' }}" href="{{ route('anime.search') }}?genre=裏番" style="color: white !important; font-weight: 400 !important;">動漫</a>
<a class="nav-item hidden-xs hidden-sm hidden-md nav-desktop-items {{ Request::is('previews/*') == '裏番' ? 'active' : '' }}" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}">新番預告</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::is('user/*/*/animelist') ? 'active' : '' }}" href="{{ Auth::check() ? route('user.animelist', ['user' => Auth::user(), 'name' => Auth::user()->name]) : route('login') }}">我的清單</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == 'Motion Anime' ? 'active' : '' }}" href="{{ route('anime.search') }}?genre=Motion+Anime">聲優</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == '3D動畫' ? 'active' : '' }}" href="{{ route('anime.search') }}?genre=3D動畫">工作人員</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == '同人作品' ? 'active' : '' }}" href="{{ route('anime.search') }}?genre=同人作品">製作公司</a>

@if (Auth::check())
    <div id="user-modal-trigger" style="padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" data-toggle="modal" data-target="#user-modal">
        <img style="width: 32px; border-radius: 4px;" src="{{ Auth::user()->avatar_temp }}">
        <i class="material-icons" style="vertical-align: middle; margin-top: 0px; margin-left: 0px; margin-right: -7px">arrow_drop_down</i>
    </div>

    <div id="user-modal" class="modal" role="dialog">
      <div id="user-modal-panel" class="modal-dialog modal-sm" style="position: absolute; top: 38px;; right: calc(4% - 1px);">
        <div class="modal-content" style="border-radius: 0px; background-color: #222222; color: white;">
            <!-- include('layouts.user-modal-content')-->
        </div>
      </div>
    </div>
@else
    <a style="padding-right: 0px; padding-left: 10px" class="nav-icon pull-right" href="{{ route('login') }}"><span style="vertical-align: middle; font-size: 28px" class="material-icons-outlined">account_circle</span></a>
@endif

<a class="nav-icon pull-right no-select" href="{{ route('anime.search') }}"><span style="vertical-align: middle; font-size: 28px;" class="material-icons-outlined">search</span></a>

<a class="nav-icon pull-right no-select" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}"><span style="vertical-align: middle; font-size: 25px" class="material-icons-outlined">cast</span></a>
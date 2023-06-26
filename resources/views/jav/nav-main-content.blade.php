<a href="/jav" style="padding-right: 2.5%; color: white; font-size: 1.4em;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('tags') && strpos(implode('', Request::get('tags')), '中文字幕') !== false  ? 'active' : '' }}" href="{{ route('jav.search') }}?tags%5B%5D=中文字幕">中文字幕</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == '日本AV' ? 'active' : '' }}" href="{{ route('jav.search') }}?genre=日本AV">日本AV</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == '素人業餘' ? 'active' : '' }}" href="{{ route('jav.search') }}?genre=素人業餘">素人業餘</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == '高清無碼' ? 'active' : '' }}" href="{{ route('jav.search') }}?genre=高清無碼">高清無碼</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == 'AI解碼' ? 'active' : '' }}" href="{{ route('jav.search') }}?genre=AI解碼">AI解碼</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == '國產AV' ? 'active' : '' }}" href="{{ route('jav.search') }}?genre=國產AV">國產AV</a>
<a class="nav-item hidden-xs nav-desktop-items {{ Request::get('genre') == '國產素人' ? 'active' : '' }}" href="{{ route('jav.search') }}?genre=國產素人">國產素人</a>
<a class="nav-item hidden-xs nav-desktop-items" href="/">H動漫</a>

@if (Auth::check())
    <div id="user-modal-trigger" style="padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" data-toggle="modal" data-target="#user-modal">
        <img style="width: 32px; border-radius: 4px;" src="{{ Auth::user()->avatar_temp }}">
        <i class="material-icons" style="vertical-align: middle; margin-top: 0px; margin-left: 0px; margin-right: -7px">arrow_drop_down</i>
    </div>

    <div id="user-modal" class="modal" role="dialog">
      <div id="user-modal-panel" class="modal-dialog modal-sm" style="position: absolute; top: 38px;; right: calc(4% - 1px);">
        <div class="modal-content" style="border-radius: 0px; background-color: #222222; color: white;">
            @include('layouts.user-modal-content')
        </div>
      </div>
    </div>
@else
    <a style="padding-right: 0px; padding-left: 10px" class="nav-icon pull-right" href="{{ route('login') }}"><span style="vertical-align: middle; font-size: 28px" class="material-icons-outlined">account_circle</span></a>
@endif

<a class="nav-icon pull-right no-select" href="{{ route('jav.search') }}"><span style="vertical-align: middle; font-size: 28px;" class="material-icons-outlined">search</span></a>

<a class="nav-icon pull-right no-select" href="{{ route('jav.search') }}"><span style="vertical-align: middle; font-size: 25px" class="material-icons-outlined">cast</span></a>
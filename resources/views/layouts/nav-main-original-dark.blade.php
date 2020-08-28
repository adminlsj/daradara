<nav id="hentai-main-nav" style="background-image: linear-gradient(to bottom,rgba(0,0,0,.7) 10%,rgba(0,0,0,0));">
  <a id="hentai-logo" class="pull-left" href="/" style="color: white; font-size: 1.4em;">
      <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
  </a>

  <form id="search-form" class="hidden-xs hidden-sm pull-left" style="width: 50%; margin-top: 14px; left:370px; position: absolute;">
      <i style="position: absolute; top: 8px; left: 17px; color: dimgray" class="material-icons">search</i>
      <input id="nav-query" name="query" style="box-shadow: none; border: 1px solid rgba(58,60,63,.85); background-color: transparent; font-size: 1.1em;border-radius: 3px; height: 40px; padding-left: 53px; color: darkgray; padding-bottom: 2px; font-weight: 500; transition: .3s cubic-bezier(0,0,.2,1);" type="text" value="{{ request('query') }}" placeholder="搜索">
  </form>

  @if (Auth::check())
    <a class="hidden-xs hidden-sm nav-item-icon" style="top: 17px; right: 4%; color: white;" href="{{ route('user.show', Auth::user()) }}"><i class="material-icons">account_circle</i></a>
    <a class="hidden-xs hidden-sm nav-item-icon" style="top: 17px; right: calc(4% + 50px); color: white;" href="{{ route('user.userEditUpload', Auth::user()) }}"><i class="material-icons">video_call</i></a>
  @else
    <a class="no-select nav-item-text hidden-xs hidden-sm" style="top: 15px; color: white; border: 1px solid transparent; padding: 8px 14px; margin-top: 12px; margin-right: 7px; font-weight: bold;" href="{{ route('login') }}">登入</a>
    <a class="no-select nav-item-text hidden-xs hidden-sm" style="top: 15px; color: white; background-color: transparent; border-color: transparent; padding: 7px 14px; margin-top: 12px; font-weight: bold;" href="{{ route('register') }}">註冊</a>
    <a class="no-select pull-right hidden-xs hidden-sm" style="top: 15px; margin-top: 15px; margin-right: 18px;" href="{{ route('login') }}"><i class="material-icons" style="color: white;">video_call</i></a>
  @endif

  <a class="hidden-md hidden-lg nav-item-icon" style="top: 16px; right: calc(4% + 2px); color: white;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i class="material-icons">account_circle</i></a>
  <a id="toggleSearchBar" class="hidden-md hidden-lg nav-item-icon" style="top: 16px; right: calc(4% + 47px); cursor: pointer; color: white;"><i class="material-icons">search</i></a>
  <a id="nav-account-icon" class="pull-right hidden-md hidden-lg nav-item-icon" style="top: 16px; right: calc(4% + 92px); color: white;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i class="material-icons">video_call</i></a>
</nav>

<nav id="hentai-filter-nav-wrapper" style="background-color: #141414; z-index: 1; padding: 0px 4%; height: 50px; border-bottom: 1px solid #141414; box-shadow: 0 3px 3px -2px rgba(0,0,0,.2),0 3px 4px 0 rgba(0,0,0,.14),0 1px 8px -8px rgba(0,0,0,.12)!important; position: fixed; top: 68px; width: 100%;" class="dark-theme-nav-main">
  <div class="container-fluid" id="hentai-filter-nav" style="height: 50px;">
    <div class="pull-left" style="color: #d1d1d1; margin-left: -15px;">
      <button style="position: relative;" type="button" data-toggle="modal" data-target="#tags"><span style="vertical-align: middle; color: darkgray;" class="material-icons">loyalty</span><span class="hidden-xs" style="margin-left: 10px">標籤</span><span class="hidden-xs" style="position: absolute; text-align: center; top: 5px; border: 1px solid crimson; border-radius: 50%; background-color: crimson; color: white; line-height: 20px; height: 22px; width: 22px; font-weight: 300; font-size: 0.8em; {{ $tags == [] ? 'display:none;' : '' }}">{{ $tags == [] ? '' : count($tags) }}</span></button>

      <button style="position: relative;" type="button" data-toggle="modal" data-target="#brands"><span style="vertical-align: middle; color: darkgray;" class="material-icons">domain</span><span class="hidden-xs" style="margin-left: 10px">品牌</span><span class="hidden-xs" style="position: absolute; text-align: center; top: 5px; border: 1px solid crimson; border-radius: 50%; background-color: crimson; color: white; line-height: 20px; height: 22px; width: 22px; font-weight: 300; font-size: 0.8em; {{ $brands == [] ? 'display:none;' : '' }}">{{ $brands == [] ? '' : count($brands) }}</span></button>

      <div style="border: 1px solid rgba(58,60,63,.85); line-height: 48px; width: 16vw; text-align: center; display: inline-block; margin-right: 4px"><span style="vertical-align: middle; color: darkgray;" class="material-icons">filter_list</span><span class="hidden-xs" style="margin-left: 10px">屏蔽</span></div>
    </div>

    <div class="pull-right" style="color: #d1d1d1; margin-right: -15px;">
      <form style="display: inline-block;" action="/search"><button style="position: relative;"><span style="vertical-align: middle; color: darkgray;" class="material-icons">clear_all</span><span class="hidden-xs" style="margin-left: 10px">重設</span></button>
      </form>
      <button id="hentai-filter-sort" style="position: relative;" type="button" data-toggle="modal" data-target="#sort-wrapper"><span style="vertical-align: middle; color: darkgray;" class="material-icons">sort</span><span class="hidden-xs" style="margin-left: 10px">排序</span></button>
    </div>
  </div>
</nav>

@include('layouts.nav-search')
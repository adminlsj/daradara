<div id="comic-nav" style="z-index: 10000 !important; position: static !important; background-color: #1f1f1f !important; background-image: none; transition: none; height: 50px; line-height: 50px;" class="main-nav no-select">
  <a class="hidden-xs hidden-sm" href="{{ route('comic.index') }}" style="padding-right: 15px; color: white; font-size: 1.4em; margin-left: 5px;">
    <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
  </a>

  <a class="hidden-md hidden-lg hover-nav" href="{{ route('comic.index') }}" style="color: white; line-height: 40px; text-decoration: none; padding: 11px 8px 12px 11px; margin: 0; border-radius: 5px;">
    <img style="margin-top: -2px" height="30" src="https://i.imgur.com/cw1H1cD.png">
  </a>

  <div id="search-form-wrapper" style="display: inline-block; position: relative; vertical-align: top;" class="comic-search-form-wrapper">
    <form id="search-form" action="{{ route('comic.search') }}" method="GET">
        <input name="query" style="background-color: #4d4d4d; height: 40px; line-height: 20px; border: none; border-top-left-radius: 5px; border-bottom-left-radius: 5px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; width: 100%; outline: none; padding-left: 10px; color: white; font-weight: 400; margin-top: 5px; vertical-align: top" type="text" value="{{ request('query') }}">
        <button class="hover-lighter" style="height: 40px; position: absolute; top: 5px; right: -38px; border: none; background-color: crimson; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
          <span style="color: white; font-weight: bolder; padding-left: 2px;" class="material-icons">search</span>
        </button>
    </form>
  </div>

  <a id="comic-menu" style="padding: 0px 8px 0px 8px; line-height: 40px; margin-top: 5px; margin-bottom: 5px; border-radius: 5px; cursor: pointer;" class="nav-icon pull-right hover-nav hidden-md hidden-lg"><span style="vertical-align: middle; margin-top: -1px;" class="material-icons">menu</span></a>

  <span class="hidden-xs hidden-sm">
    <a style="padding-left: 10px; cursor: pointer;" class="comic-nav-item comic-random-nav-item">隨機推薦</a>
    <a style="margin-left: -4px;" class="comic-nav-item {{ Request::is('*comics/tags') ? 'active' : ''}}" href="{{ route('comic.showTags', ['column' => 'tags']) }}">標籤</a>
    <a style="margin-left: -4px;" class="comic-nav-item {{ Request::is('*comics/artists') ? 'active' : ''}}" href="{{ route('comic.showTags', ['column' => 'artists']) }}">作者</a>
    <a style="margin-left: -3px;" class="comic-nav-item {{ Request::is('*comics/characters') ? 'active' : ''}}" href="{{ route('comic.showTags', ['column' => 'characters']) }}">角色</a>
    <a style="margin-left: -4px;" class="comic-nav-item {{ Request::is('*comics/parodies') ? 'active' : ''}}" href="{{ route('comic.showTags', ['column' => 'parodies']) }}">同人</a>
    <a style="margin-left: -4px;" class="comic-nav-item {{ Request::is('*comics/groups') ? 'active' : ''}}" href="{{ route('comic.showTags', ['column' => 'groups']) }}">社團</a>
    <a style="margin-left: -4px;" class="comic-nav-item" href="/">H動漫</a>

    <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}"><span style="vertical-align: middle;" class="material-icons">account_circle</span></a>
    <a class="nav-icon pull-right" href="#"><span style="vertical-align: middle; font-size: 23px; margin-top: -2px;" class="material-icons">favorite</span></a>
    <a class="nav-icon pull-right" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login') }}"><span style="vertical-align: middle;" class="material-icons">video_call</span></a>
  </span>
</div>

<span id="comic-nav-mobile" style="display: none;" class="hidden-md hidden-lg">
  <a style="cursor: pointer; text-decoration: none;" class="comic-random-nav-item"><div class="comic-nav-item-mobile">隨機推薦</div></a>
  <a style="text-decoration: none;" href="{{ route('comic.showTags', ['column' => 'tags']) }}"><div class="comic-nav-item-mobile">標籤</div></a>
  <a style="text-decoration: none;" href="{{ route('comic.showTags', ['column' => 'artists']) }}"><div class="comic-nav-item-mobile">作者</div></a>
  <a style="text-decoration: none;" href="{{ route('comic.showTags', ['column' => 'characters']) }}"><div class="comic-nav-item-mobile">角色</div></a>
  <a style="text-decoration: none;" href="{{ route('comic.showTags', ['column' => 'parodies']) }}"><div class="comic-nav-item-mobile">同人</div></a>
  <a style="text-decoration: none;" href="{{ route('comic.showTags', ['column' => 'groups']) }}"><div class="comic-nav-item-mobile">社團</div></a>
  <a style="text-decoration: none;" href="/"><div class="comic-nav-item-mobile">H動漫</div></a>
</span>

<script>
  $('#comic-menu').click(function() {
    $('#comic-nav-mobile').toggle();
  })
</script>
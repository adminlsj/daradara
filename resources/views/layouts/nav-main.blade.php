<nav style="box-shadow: 0 9px 9px -9px rgba(0,0,0,0.1); padding: 0px calc(4% - 15px)" class="{{ $theme == 'dark' ? 'dark-theme-nav-main' : 'white-theme-nav-main' }}">
  <div class="container-fluid">
    <div style="height: 50px;">

      <a style="text-decoration: none;" href="/">
          <img src="https://i.imgur.com/SyISzCK.png" style="margin-top:-8px;" height="24" alt="娛見日本 LaughSeeJapan">
          <span class="logo-text">LaughSeeJapan</span>
      </a>

      <span id="nav-menu-trigger" class="hidden-xs" style="color: #cf2d52; font-size: 1.05em; margin-left: 20px; text-decoration: none; cursor: pointer; padding-bottom: 15px;">
      	<span>搜索內容</span>
      	<span class="caret-reversed"></span>
      	<div class="caret"></div>
		<div class="nav-menu-list">
			<div class="nav-menu-wrapper" style="width: calc(4% + 200px); height: 113px; border-right: 1px solid #cf2d52; float: left;">
				<div style="padding-top:12px">
					<a href="/">主頁</a>
				</div>
				<div>
					<a href="{{ route('video.rank') }}">發燒影片</a>
				</div>
				<div>
					<a href="{{ route('video.newest') }}">最新內容</a>
				</div>
			</div>
			<div style="float: left; padding-left: 25px;">
				<div style="padding-top:12px">
					<a href="{{ route('video.variety') }}" style="font-weight: 400;">綜藝</a>
				</div>
				<div style="padding-top: 5px">
					<a href="{{ route('video.drama') }}" style="font-weight: 400;">日劇</a>
				</div>
				<div style="padding-top: 5px">
					<a href="{{ route('video.anime') }}" style="font-weight: 400;">動漫</a>
				</div>
			</div>
			<div style="float: left; padding-left: 25px;">
				<div style="padding-top:12px">
					<a href="{{ route('video.subscribeTag') }}?query=明星" style="font-weight: 400;" href="/">明星嘉賓</a>
				</div>
				<div style="padding-top: 5px">
					<a href="{{ route('video.subscribeTag') }}?query=整人" style="font-weight: 400;">整人企劃</a>
				</div>
				<div style="padding-top: 5px">
					<a href="{{ route('video.subscribeTag') }}?query=真人秀" style="font-weight: 400;">真人秀</a>
				</div>
			</div>
		</div>
      </span>

      <a class="hidden-xs hidden-sm" style="color: #cf2d52; font-size: 1.05em; margin-left: 15px" href="{{ Auth::check() ? route('video.subscribes') : route('login')}}">訂閱項目</a>

      <a class="no-select nav-item-text" style="color: #cf2d52; border: 2px solid #cf2d52;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><span class="hidden-xs">我的</span>帳戶</a>

      <a class="no-select nav-item-text" style="color: white; background-color: #d84b6b; border: 2px solid #d84b6b;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}">訂閱<span class="hidden-xs">項目</span></a>

      <form id="search-form" class="hidden-xs" style="display: inline-block; float: right; margin-top: 9px" action="{{ route('video.search') }}" method="GET">
	      <input id="query" name="query" style="vertical-align:middle; box-shadow: none; border: 1px solid #d84b6b; background-color: white; font-size: 1em; width: 200px; border-top-left-radius: 2px; border-bottom-left-radius: 2px; height: 31px; padding-left: 10px;" type="text" value="{{ request('query') }}" placeholder="最新日本綜藝、日劇、動漫">
	      <a id="search-submit-btn" type="submit" style="cursor: pointer;"><i style="font-size: 22px; vertical-align:middle; border: 1px solid #d84b6b; background-color: #d84b6b; color: white; padding: 3.5px 10px; margin-top: -1px; margin-left: -4px; border-top-right-radius: 2px; border-bottom-right-radius: 2px;" class="material-icons no-select">search</i></a>
	  </form>

      <a id="toggleSearchBar" class="pull-right hidden-sm hidden-md hidden-lg" style="padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </div>
  </div>
</nav>

@include('layouts.nav-search')

@include('layouts.nav-bottom')
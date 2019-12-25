<nav style="background-color: {{ !Request::is('/') && !Request::is('*rank*') && !Request::is('*search*') && $is_program ? '#222222' : 'white' }}" id="scroll-hide-nav" >
  <div style="width: 80%; max-width: 1200px; background-color: {{ !Request::is('/') && !Request::is('*rank*') && !Request::is('*search*') && $is_program ? '#222222' : 'white' }}" class="container-fluid responsive-frame">
    <div style="background-color: {{ !Request::is('/') && !Request::is('*rank*') && !Request::is('*search*') && $is_program ? '#222222' : 'white' }}">
      <a href="/">
	        <img src="{{ !Request::is('/') && !Request::is('*rank*') && !Request::is('*search*') && $is_program ? 'https://i.imgur.com/xSMGFWh.png' : 'https://i.imgur.com/M8tqx5K.png' }}" style="margin-top: -6px;" height="30" alt="娛見日本 LaughSeeJapan">
	    </a>

	    <a style="font-size: 25px; line-height: 50px;" href="/"> </a>

      <a class="pull-right" style="color: {{ !Request::is('/') && !Request::is('*rank*') && !Request::is('*search*') && $is_program ? 'white' : 'gray' }}; padding: 0px 0px 0px 15px;" href="/"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="pull-right" style="color: {{ !Request::is('/') && !Request::is('*rank*') && !Request::is('*search*') && $is_program ? 'white' : 'gray' }}; padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </div>
  </div>
</nav>

<nav style="background-color: #e0e0e0 !important; height: 50px; display: none;" id="searchBar" class="">
  <div style="width: 80%; max-width: 1200px; background-color: #e0e0e0 !important;" class="container-fluid responsive-frame">
    <form id="search-form" style="background-color: #e0e0e0 !important;" action="{{ route('blog.search') }}" method="GET">
      <a id="toggleSearchBar" style="color: #646464 !important; padding: 0px 15px 0px 0px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">arrow_back</i></a>

      <input id="query" name="query" style="vertical-align:middle; margin-bottom: -27px" type="text" placeholder="搜索最新日本綜藝、日劇、動漫！">

      <a id="search-submit-btn" type="submit" style="color: #646464 !important; padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </form>
  </div>
</nav>

<nav style="background-color: white; margin-top: 49px; {{ Request::is('*rank*') ? '' : 'display:none;' }}" id="scroll-hide-nav2" >
  <div style="width: 80%; max-width: 1200px; background-color: {{ Request::is('*watch*') ? '#222222' : 'white' }}" class="container-fluid responsive-frame">
    <div class="nav-tab-container" style="background-color: white;">
      <a href="{{ route('video.rank') }}" style="width: 25%; float:left; text-align: center; text-decoration: none;">
        <h4 class="{{ !Request::has('g') ? 'nav-tab-active' : '' }}"><span>&nbsp;全部&nbsp;</span></h4>
      </a>
      <a href="{{ route('video.rank') }}?g=variety" style="width: 25%; float:left; text-align: center; text-decoration: none;">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'variety' ? 'nav-tab-active' : '' }}"><span>&nbsp;綜藝&nbsp;</span></h4>
      </a>
      <a href="{{ route('video.rank') }}?g=drama" style="width: 25%; float:left; text-align: center; text-decoration: none;">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'drama' ? 'nav-tab-active' : '' }}"><span>&nbsp;日劇&nbsp;</span></h4>
      </a>
      <a href="{{ route('video.rank') }}?g=anime" style="width: 25%; float:left; text-align: center; text-decoration: none;">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'anime' ? 'nav-tab-active' : '' }}"><span>&nbsp;動漫&nbsp;</span></h4>
      </a>
    </div>
  </div>
</nav>

<nav style="background-color: #222222; margin-top: 49px; {{ Request::is('drama') || Request::is('anime') ? '' : 'display:none;' }}" id="scroll-hide-nav3" >
  <div style="width: 80%; max-width: 1200px; background-color: #222222" class="container-fluid responsive-frame">
    <div class="nav-tab-container-watch" style="background-color: white;">
      <a class="watch-year-nav">
        <h4>
          <div class="custom-select">
            <select id="watch-year-select">
              <option {{ Request::has('y') && Request::get('y') == '2019' ? 'selected' : '' }} value="2019">2019年</option>
              <option {{ Request::has('y') && Request::get('y') == '2019' ? 'selected' : '' }} value="2019">2019年</option>
              <option {{ Request::has('y') && Request::get('y') == '2018' ? 'selected' : '' }} value="2018">2018年</option>
              <option {{ Request::has('y') && Request::get('y') == '2017' ? 'selected' : '' }} value="2017">2017年</option>
              <option {{ Request::has('y') && Request::get('y') == '2016' ? 'selected' : '' }} value="2016">2016年</option>
              <option {{ Request::has('y') && Request::get('y') == '2015' ? 'selected' : '' }} value="2015">2015年</option>
            </select>
          </div>
        </h4>
      </a>
      <a class="watch-month-nav" href="{{ Request::path() }}?y={{ Request::get('y') }}&m=1">
        <h4 class="{{ Request::has('m') && Request::get('m') == '1' ? 'nav-tab-active' : '' }}"><span>&nbsp;1月&nbsp;</span></h4>
      </a>
      <a class="watch-month-nav" href="{{ Request::path() }}?y={{ Request::get('y') }}&m=4">
        <h4 class="{{ Request::has('m') && Request::get('m') == '4' ? 'nav-tab-active' : '' }}"><span>&nbsp;4月&nbsp;</span></h4>
      </a>
      <a class="watch-month-nav" href="{{ Request::path() }}?y={{ Request::get('y') }}&m=7">
        <h4 class="{{ Request::has('m') && Request::get('m') == '7' ? 'nav-tab-active' : '' }}"><span>&nbsp;7月&nbsp;</span></h4>
      </a>
      <a class="watch-month-nav" href="{{ Request::path() }}?y={{ Request::get('y') }}&m=10">
        <h4 class="{{ Request::has('m') && Request::get('m') == '10' ? 'nav-tab-active' : '' }}"><span>&nbsp;10月&nbsp;</span></h4>
      </a>
    </div>
  </div>
</nav>

<div class="navbar">
  <a href="/" class="{{ Request::is('/') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">home</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">主頁</span>
  </a>
  <a href="{{ route('video.rank') }}" class="{{ Request::is('*rank*') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">whatshot</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">熱門</span>
  </a>
  <a href="{{ route('video.variety') }}" class="{{ strpos(Request::path(), 'variety' ) !== false || (Request::has('v') && $video->genre == 'variety') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">live_tv</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">綜藝</span>
  </a>
  <a href="{{ route('video.drama') }}" class="{{ strpos(Request::path(), 'drama' ) !== false || (Request::has('v') && $video->genre == 'drama') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">movie_filter</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">日劇</span>
  </a>
  <a href="{{ route('video.anime') }}" class="{{ strpos(Request::path(), 'anime' ) !== false || (Request::has('v') && $video->genre == 'anime') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">palette</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">動漫</span>
  </a>
</div>
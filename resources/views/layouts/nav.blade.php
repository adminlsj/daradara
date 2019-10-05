<nav style="background-color: {{ Request::is('*watch*') ? '#333333' : 'white' }}" id="scroll-hide-nav" >
  <div style="width: 80%; max-width: 1200px; background-color: {{ Request::is('*watch*') ? '#333333' : 'white' }}" class="container-fluid responsive-frame">
    <div style="background-color: {{ Request::is('*watch*') ? '#333333' : 'white' }}">
      <a href="/home">
	        <img src="{{ Request::is('*watch*') ? 'https://i.imgur.com/xSMGFWh.png' : 'https://i.imgur.com/M8tqx5K.png' }}" style="margin-top: -6px;" height="30px">
	    </a>

	    <a style="font-size: 25px; line-height: 50px;" href="/home"> </a>

      <a class="pull-right" style="color: {{ Request::is('*watch*') ? 'white' : 'gray' }}; padding: 0px 0px 0px 15px;" href="/"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="pull-right" style="color: {{ Request::is('*watch*') ? 'white' : 'gray' }}; padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </div>
  </div>
</nav>

<nav style="background-color: #e0e0e0 !important; height: 50px; display: none;" id="searchBar" class="">
  <div style="width: 80%; max-width: 1200px; background-color: #e0e0e0 !important;" class="container-fluid responsive-frame">
    <form id="search-form" style="background-color: #e0e0e0 !important;" action="{{ route('blog.search') }}" method="GET">
      <a id="toggleSearchBar" style="color: #646464 !important; padding: 0px 15px 0px 0px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">arrow_back</i></a>

      <input id="query" name="query" style="vertical-align:middle; margin-bottom: -27px" type="text" placeholder="Search FreeRider">

      <a id="search-submit-btn" type="submit" style="color: #646464 !important; padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </form>
  </div>
</nav>

<div class="navbar">
  <a href="/home" class="{{ Request::is('/') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">home</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">主頁</span>
  </a>
  <a href="{{ route('video.trending') }}" class="{{ Request::is('*trending*') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">whatshot</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">發燒影片</span>
  </a>
  <a href="{{ route('video.watch') }}" class="{{ Request::is('*watch*') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">subscriptions</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">節目列表</span>
  </a>
</div>
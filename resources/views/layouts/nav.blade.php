<nav style="background-color: #414143 !important;" id="scroll-hide-nav" >
  <div style="width: 80%; max-width: 1200px; background-color: #414143 !important;" class="container-fluid responsive-frame">
    <div style="background-color: #414143 !important;">
      <a href="/">
	        <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/square_freerider_profile_pic.jpg" style="border-radius: 20px; margin-top: -14px;" width="40px" height="40px">
	    </a>

	    <a style="font-size: 25px; color: white !important; font-weight: 300; line-height: 50px; text-decoration: none; margin-left: -5px;" href="/">FreeRider</a>

      <a class="pull-right" style="color: #f2f2f2 !important; padding: 0px 0px 0px 15px;" href="{{ route('blog.genre.index', ['genre' => 'laughseejapan']) }}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="pull-right" style="color: #f2f2f2 !important; padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
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
  <a href="/" class="{{ Request::is('/') ? 'active' : ''}}">
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
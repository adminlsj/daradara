<nav style="background-color: #414143 !important;" id="scroll-hide-nav" class="responsive-frame">
  <div style="width: 80%; background-color: #414143 !important;" class="container-fluid">
    <div style="background-color: #414143 !important;">
      <a href="{{ route('blog.genre.index', ['genre' => 'laughseejapan']) }}">
	        <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/square_freerider_profile_pic.jpg" style="border-radius: 20px; margin-top: -14px;" width="40px" height="40px">
	    </a>

	    <a style="font-size: 25px; color: white !important; font-weight: 300; line-height: 50px; text-decoration: none; margin-left: -5px;" href="{{ route('blog.genre.index', ['genre' => $genre]) }}">FreeRider</a>

      <a class="pull-right" style="color: #f2f2f2 !important; padding: 0px 0px 0px 15px;" href="{{ route('blog.genre.index', ['genre' => 'laughseejapan']) }}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
      <a class="pull-right" style="color: #f2f2f2 !important; padding: 0px 0px 15px 15px;" href="{{ route('blog.genre.index', ['genre' => 'laughseejapan']) }}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </div>
  </div>
</nav>

<div class="navbar">
  <a href="{{ route('blog.genre.index', ['genre' => 'laughseejapan']) }}" class="{{ Request::is('laughseejapan') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">home</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">主頁</span>
  </a>
  <a href="{{ route('blog.category.index', ['genre' => 'laughseejapan', 'category' => 'trending']) }}" class="{{ Request::is('*trending') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">whatshot</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">發燒影片</span>
  </a>
  <a href="{{ route('blog.genre.index', ['genre' => 'watch']) }}" class="{{ Request::is('*watch*') ? 'active' : ''}}">
    <i style="font-size: 25px;" class="material-icons">nights_stay</i>
    <span style="font-size: 12px; position: fixed; bottom: 0; padding-bottom: 4px; color: inherit;">月曜合集</span>
  </a>
</div>
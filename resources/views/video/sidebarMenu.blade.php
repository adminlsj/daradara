<div class="{{ $theme == 'dark' ? 'dark-theme' : 'white-theme' }}" style="margin-right: -30px;">
	@include('video.sidebarItem', ['link' => '/', 'is_current' => Request::is('/') ? 'active' : '', 'icon' => 'home', 'title' => '首頁'])
	@include('video.sidebarItem', ['link' => route('video.rank'), 'is_current' => Request::is('*rank*') ? 'active' : '', 'icon' => 'whatshot', 'title' => '發燒影片'])
	<hr style="margin: 10px 0px;">
	@include('video.sidebarItem', ['link' => route('video.variety'), 'is_current' => strpos(Request::path(), 'variety' ) !== false || (Request::has('v') && $current->genre == 'variety') ? 'active' : '', 'icon' => 'live_tv', 'title' => '綜藝'])
	@include('video.sidebarItem', ['link' => route('video.drama'), 'is_current' => strpos(Request::path(), 'drama' ) !== false || (Request::has('v') && $current->genre == 'drama') ? 'active' : '', 'icon' => 'movie_filter', 'title' => '日劇'])
	@include('video.sidebarItem', ['link' => route('video.anime'), 'is_current' => strpos(Request::path(), 'anime' ) !== false || (Request::has('v') && $current->genre == 'anime') ? 'active' : '', 'icon' => 'palette', 'title' => '動漫'])
	<hr style="margin: 10px 0px">
	<div style="margin-left: 26px; color: #595959; font-weight: 500; padding-top: 5px;">LaughSeeJapan 推薦</div>
</div>
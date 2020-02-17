<div class="{{ $theme == 'dark' ? 'dark-theme' : 'white-theme' }}" style="margin-right: -20px; height: 100vh; overflow-y: scroll; overflow-x: hidden;">
	@include('video.sidebarItem', ['link' => '/', 'is_current' => Request::is('/') ? 'active' : '', 'icon' => 'home', 'title' => '首頁'])
	@include('video.sidebarItem', ['link' => route('video.rank'), 'is_current' => Request::is('*rank*') ? 'active' : '', 'icon' => 'whatshot', 'title' => '發燒影片'])
	<hr style="margin: 10px 0px;">
	@include('video.sidebarItem', ['link' => route('video.variety'), 'is_current' => strpos(Request::path(), 'variety') !== false && !isset($watch) || Request::has('v') && $current->genre == 'variety' ? 'active' : '', 'icon' => 'live_tv', 'title' => '綜藝'])
	@include('video.sidebarItem', ['link' => route('video.drama'), 'is_current' => strpos(Request::path(), 'drama' ) !== false || (Request::has('v') && $current->genre == 'drama') ? 'active' : '', 'icon' => 'movie_filter', 'title' => '日劇'])
	@include('video.sidebarItem', ['link' => route('video.anime'), 'is_current' => strpos(Request::path(), 'anime' ) !== false || (Request::has('v') && $current->genre == 'anime') ? 'active' : '', 'icon' => 'palette', 'title' => '動漫'])
	<hr style="margin: 10px 0px;">
	<div style="margin-left: 26px; color: #595959; font-weight: 500; padding-top: 8px; padding-bottom: 10px;">LaughSeeJapan 推薦</div>
	@include('video.sidebarRecommend', ['link' => route('video.intro', ['variety', '月曜夜未央']), 'is_current' => isset($watch) && $watch->category == 'monday' && !Request::has('v') ? 'active' : '', 'icon' => 'iXyOfUs', 'title' => '月曜夜未央'])
	@include('video.sidebarRecommend', ['link' => route('video.intro', ['variety', '人類觀察']), 'is_current' => isset($watch) && $watch->category == 'monitoring' && !Request::has('v') ? 'active' : '', 'icon' => 'wLpWH5h', 'title' => '人類觀察'])
	@include('video.sidebarRecommend', ['link' => route('video.intro', ['variety', '24小時不准笑']), 'is_current' => isset($watch) && $watch->category == '24xsbzx' && !Request::has('v') ? 'active' : '', 'icon' => 'EK6Lyip', 'title' => '24小時不准笑'])
	@include('video.sidebarRecommend', ['link' => route('video.intro', ['variety', '跟拍到你家']), 'is_current' => isset($watch) && $watch->category == 'home' && !Request::has('v') ? 'active' : '', 'icon' => 'NF0Gqew', 'title' => '跟拍到你家'])
	@include('video.sidebarRecommend', ['link' => route('video.intro', ['variety', '交給嵐吧_嵐的大挑戰']), 'is_current' => isset($watch) && $watch->category == 'lddtz' && !Request::has('v') ? 'active' : '', 'icon' => 'jBZX4mj', 'title' => '交給嵐吧'])
	@include('video.sidebarRecommend', ['link' => route('video.intro', ['variety', '閒聊007']), 'is_current' => isset($watch) && $watch->category == 'talk' && !Request::has('v') ? 'active' : '', 'icon' => 'BqVcMd9', 'title' => '閒聊007'])
	<hr style="margin: 10px 0px;">

	<div class="row sidebar-footer">
		<div class="col-sm-12 col-md-12" style="margin-left: 25px;">
            <div><a href="https://www.facebook.com/laughseejapan/" target="_blank">娛見日本</a>&nbsp;<a href="https://www.facebook.com/%E6%97%A5%E5%A8%9B%E7%8E%8B%E9%81%93-117672486306487/" target="_blank">日娛王道</a></div>
            <div style="margin-top: -5px;"><a href="https://www.facebook.com/freeriderjapan/" target="_blank">這裡是日本</a></div>
        </div>
        <div class="col-sm-12 col-md-12" style="margin-left: 25px;">
            <div><a href="/about-us">關於</a>&nbsp;<a href="/policy">免責聲明</a>&nbsp;<a href="/policy">私隱條例</a></div>
            <div style="margin-top: -5px;"><a href="/about-us">與我們聯絡</a>&nbsp;<a href="/about-us">廣告</a></div>
        </div>
        <div class="col-sm-12 col-md-12" style="margin-left: 25px; margin-top: 10px">
            <div style="font-size: 0.8em; color: gray">© 2020 娛見日本 LaughSeeJapan</div>
        </div>
    </div>
</div>
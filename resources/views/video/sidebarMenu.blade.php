<div class="{{ $theme == 'dark' ? 'dark-theme' : 'white-theme' }}">
	@include('video.sidebarItem', ['link' => '/', 'is_current' => Request::is('/') ? 'active' : '', 'icon' => 'home', 'title' => '首頁'])
	@include('video.sidebarItem', ['link' => route('video.rank'), 'is_current' => Request::is('*rank*') ? 'active' : '', 'icon' => 'whatshot', 'title' => '發燒影片'])
	@include('video.sidebarItem', ['link' => route('video.newest'), 'is_current' => Request::is('*newest*') ? 'active' : '', 'icon' => 'explore', 'title' => '最新內容'])
	@include('video.sidebarItem', ['link' => route('video.subscribes'), 'is_current' => Request::is('*subscribes*') ? 'active' : '', 'icon' => 'subscriptions', 'title' => '訂閱項目'])
	
	<hr style="margin: 10px 0px;">
	
	@include('video.sidebarItem', ['link' => '', 'is_current' => '', 'icon' => 'watch_later', 'title' => '稍後觀看'])
	@include('video.sidebarItem', ['link' => '', 'is_current' => '', 'icon' => 'thumb_up', 'title' => '喜歡的影片'])
	@include('video.sidebarItem', ['link' => '', 'is_current' => '', 'icon' => 'history', 'title' => '觀看紀錄'])

	<hr style="margin: 10px 0px;">

	<!--<div style="margin-left: 26px; color: #595959; font-weight: 500; padding-top: 8px; padding-bottom: 10px;">最新訂閱內容</div>
	@foreach (App\Watch::orderBy('updated_at', 'desc')->limit(6)->get() as $watch)
		@include('video.sidebarRecommend', ['link' => route('video.intro', ['channel', $watch->titleToUrl()]), 'is_current' => false, 'icon' => $watch->imgur, 'title' => $watch->title])
	@endforeach

	<hr style="margin: 10px 0px;">-->
	
	<div class="row sidebar-footer">
		<div class="col-sm-12 col-md-12" style="margin-left: 25px;">
            <div><a href="https://www.facebook.com/laughseejapan/" target="_blank">娛見日本</a>&nbsp;<a href="https://www.facebook.com/%E6%97%A5%E5%A8%9B%E7%8E%8B%E9%81%93-117672486306487/" target="_blank">日娛王道</a></div>
            <div style="margin-top: -5px;"><a href="https://www.facebook.com/freeriderjapan/" target="_blank">這裡是日本</a></div>
        </div>
        <div class="col-sm-12 col-md-12" style="margin-left: 25px;">
            <div><a href="/about-us">關於</a>&nbsp;<a href="/terms">服務條款</a>&nbsp;<a href="/policies">社群規範</a></div>
            <div style="margin-top: -5px;"><a href="/about-us">與我們聯絡</a>&nbsp;<a href="/copyright">版權</a></div>
        </div>
        <div class="col-sm-12 col-md-12" style="margin-left: 25px; margin-top: 5px">
            <div style="font-size: 0.8em; color: gray">© 2020 娛見日本 LaughSeeJapan</div>
        </div>
    </div>
    <br><br><br>
</div>
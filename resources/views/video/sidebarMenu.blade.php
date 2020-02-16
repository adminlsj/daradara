<div class="{{ $theme == 'dark' ? 'dark-theme' : 'white-theme' }}" style="margin-right: -20px; height: 100vh; overflow-y: scroll;">
	@include('video.sidebarItem', ['link' => '/', 'is_current' => Request::is('/') ? 'active' : '', 'icon' => 'home', 'title' => '首頁'])
	@include('video.sidebarItem', ['link' => route('video.rank'), 'is_current' => Request::is('*rank*') ? 'active' : '', 'icon' => 'whatshot', 'title' => '發燒影片'])
	<hr style="margin: 10px 0px;">
	@include('video.sidebarItem', ['link' => route('video.variety'), 'is_current' => strpos(Request::path(), 'variety' ) !== false || (Request::has('v') && $current->genre == 'variety') ? 'active' : '', 'icon' => 'live_tv', 'title' => '綜藝'])
	@include('video.sidebarItem', ['link' => route('video.drama'), 'is_current' => strpos(Request::path(), 'drama' ) !== false || (Request::has('v') && $current->genre == 'drama') ? 'active' : '', 'icon' => 'movie_filter', 'title' => '日劇'])
	@include('video.sidebarItem', ['link' => route('video.anime'), 'is_current' => strpos(Request::path(), 'anime' ) !== false || (Request::has('v') && $current->genre == 'anime') ? 'active' : '', 'icon' => 'palette', 'title' => '動漫'])
	<hr style="margin: 10px 0px;">
	<div style="margin-left: 26px; color: #595959; font-weight: 500; padding-top: 5px; padding-bottom: 5px;">LaughSeeJapan 推薦</div>
	<hr style="margin: 10px 0px;">

	<div class="row sidebar-footer">
        <div class="col-sm-12 col-md-12 text-center">
            <div style="color: #595959; font-weight: 500; padding-top: 5px;">探索</div>
            <div><a href="{{ route('video.variety') }}">綜藝</a></div>
            <div><a href="{{ route('video.drama') }}">日劇</a></div>
            <div><a href="{{ route('video.anime') }}">動漫</a></div>
        </div>
        <div class="col-sm-12 col-md-12 text-center">
            <div style="color: #595959; font-weight: 500; padding-top: 15px;">社群</div>
            <div><a href="https://www.facebook.com/laughseejapan/" target="_blank">娛見日本</a></div>
            <div><a href="https://www.facebook.com/%E6%97%A5%E5%A8%9B%E7%8E%8B%E9%81%93-117672486306487/" target="_blank">日娛王道</a></div>
            <div><a href="https://www.facebook.com/freeriderjapan/" target="_blank">這裡是日本</a></div>
        </div>
        <div class="col-sm-12 col-md-12 text-center">
            <div style="color: #595959; font-weight: 500; padding-top: 15px;">娛見日本</div>
            <div><a href="/about-us">關於我們</a></div>
            <div><a href="/policy">免責聲明</a></div>
            <div><a href="/policy">私隱條例</a></div>
        </div>
	</div>

	<div class="footer-copyright padding-setup" style="margin-top: 25px; text-align: center">
        <p style="white-space: pre-wrap; padding-bottom: 50px; margin-left: auto; margin-right: auto;">本網站內容收集於互聯網上公開資源，提供最優質的網頁界面服務，但不提供也不參與影片檔案錄製、下載、上傳、儲存。娛見日本Laughseejapan 不承擔任何由於內容的合法性所引起的爭議和法律責任。若本站收錄的資源涉及您的版權或知識產權或其他利益，<a style="color: gray" href="/policy" target="_blank">請留言並附上版權證明</a>，我們會盡快確認後作出刪除等處理措施，以保護版權方的權益 。

Copyright @ 2019 娛見日本 LaughSeeJapan</p>
    </div>
</div>
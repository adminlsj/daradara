<div class="white-theme">
	@include('video.sidebarItem', ['link' => '/', 'is_current' => Request::is('/') ? 'active' : '', 'icon' => 'home', 'title' => '首頁', 'marginTop' => '1px'])
	@include('video.sidebarItem', ['link' => route('video.rank'), 'is_current' => Request::is('*rank*') ? 'active' : '', 'icon' => 'whatshot', 'title' => '發燒影片', 'marginTop' => '0px'])
    @if (Auth::check() && auth()->user()->subscribes()->first())
        @include('video.sidebarItem', ['link' => route('video.recommend'), 'is_current' => Request::is('*recommend*') ? 'active' : '', 'icon' => 'explore', 'title' => '最新推薦', 'marginTop' => '1px'])
    @else
        @include('video.sidebarItem', ['link' => route('video.newest'), 'is_current' => Request::is('*newest*') ? 'active' : '', 'icon' => 'explore', 'title' => '最新內容', 'marginTop' => '1px'])
    @endif
	@include('video.sidebarItem', ['link' => route('video.subscribes'), 'is_current' => Request::is('*subscribes*') ? 'active' : '', 'icon' => 'subscriptions', 'title' => '訂閱項目', 'marginTop' => '0px'])

    <div style="padding-top: 20px; padding-left: 25px; padding-bottom: 10px; color: #666666; font-weight: 400; font-size: 13px">關於</div>

    @include('video.sidebarItem', ['link' => '/about', 'is_current' => Request::is('about') ? 'active' : '', 'icon' => 'account_tree', 'title' => '娛見日本', 'marginTop' => '1px'])
    @include('video.sidebarItem', ['link' => '/contact', 'is_current' => Request::is('contact') ? 'active' : '', 'icon' => 'mail', 'title' => '與我們聯絡', 'marginTop' => '1px'])
    @include('video.sidebarItem', ['link' => '/terms', 'is_current' => Request::is('terms') ? 'active' : '', 'icon' => 'developer_board', 'title' => '服務條款', 'marginTop' => '1px'])
    @include('video.sidebarItem', ['link' => '/policies', 'is_current' => Request::is('policies') ? 'active' : '', 'icon' => 'policy', 'title' => '社群規範', 'marginTop' => '0px'])
    @include('video.sidebarItem', ['link' => '/copyright', 'is_current' => Request::is('copyright') ? 'active' : '', 'icon' => 'report', 'title' => '版權申訴', 'marginTop' => '1px'])
	
    <div style="margin-left: 25px; margin-top: 5px; position: absolute; bottom: 70px;">
        <div style="font-size: 0.8em; color: gray">© 2020 娛見日本 LaughSeeJapan</div>
    </div>
    <br><br><br>
</div>
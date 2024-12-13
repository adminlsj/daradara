<div class="navbar-wrapper {{ Request::is('/') ? 'navbar-wrapper-solid' : '' }}">
    <div class="navbar">
        <div class="icon">
            <a href="/">
                <img src="https://anilist.co/img/icons/icon.svg" alt="">
            </a>
        </div>

        <div class="navbar-links flex-row" style="color: yellow !important;">
            <a href="/">首頁</a>
            <a href="">動漫</a>
            <a href="">新番預告</a>
            <a href="{{ Auth::check() ? route('user.animelist', ['user' => Auth::user(), 'name' => Auth::user()->name]) : route('login') }}">我的清單</a>
            <a href="">聲優</a>
            <a href="">工作人員</a>
            <a href="">製作公司</a>
        </div>

        <a href="{{ route('login') }}" class="navbar-search-user flex-row">
            <button><i class="fa fa-search" style="vertical-align: middle; margin-right: 5px; color: rgba(191,193,212,.65);"></i></button>
            <div class="navbar-user">
                <button><img src="https://s4.anilist.co/file/anilistcdn/user/avatar/large/b6795738-jlozljJN1rp5.jpg" alt=""></button>
                <button><i style="font-size: 20px; margin-top: 0px; vertical-align: middle; margin-left: -5px; color: rgba(191,193,212,.65)" class="fa fa-caret-down"></i></button>
            </div>
        </a>
    </div>
</div>
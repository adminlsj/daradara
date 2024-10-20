<div class="navbar ">
    <div class="icon">
        <a href="/">
            <img src="https://anilist.co/img/icons/icon.svg" alt="">
        </a>
    </div>

    <div class="navbar-wrap flex-row">
        <a href="">個人資料</a>
        <a href="{{ Auth::check() ? route('user.animelist', ['user' => Auth::user()->id, 'name' => Auth::user()->name]) : route('login') }}">動漫清單</a>
        <div class="search-wrap">
            <a href="">尋找</a>
            <div class="search-dropdown">
                <div class="primary-links">
                    <div class="primary-link search-anime">
                        <a href="" style="font-size:18px;">▶</a>
                        <div class="primary-link-card">
                            <a href="">動畫</a>
                            <div class="secondary-links">
                                <a href="">Top 100</a>
                                <a href="">流行中</a>
                                <a href="">電影推薦</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="">論壇區</a>
    </div>

    <a href="{{ route('login') }}" class="navbar-search-user flex-row">
        <button><i class="fa fa-search" style="margin-right:18px"></i></button>
        <div class="navbar-user">
            <button><img src="https://i.meee.com.tw/7v5tUUL.jpeg" alt=""></button>
            <button><i class="fa fa-caret-down"></i></button>
        </div>
    </a>
</div>
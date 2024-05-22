<nav class="navbar" style="height: 75px; margin-bottom: 0px;">
    <div style="max-width: 1260px; margin: auto; padding-left: 30px; padding-right: 30px;">

        <a href="/" class="pull-left" style="margin-top: 19px">
            <img src="https://puku-dist.4gamers.com.tw/site/img/4gamers-logo-light.5004fe5b.svg" alt="logo" height="40">
        </a>

        @if (Auth::check())
            <a href="{{ route('anime.show', ['anime' => 1, 'title' => '為美好的世界獻上祝福！']) }}" class="pull-right nav-item">
                <img style="border-radius: 50%;" src="https://img.4gamers.com.tw/default-image/default-member-avatar-20231017.png" alt="account" height="28">
            </a>
        @else
            <a href="{{ route('login') }}" class="pull-right nav-item">
                <img style="border-radius: 50%;" src="https://img.4gamers.com.tw/default-image/default-member-avatar-20231017.png" alt="account" height="28">
            </a>
        @endif

        <a href="/" class="pull-right nav-item" style="margin-right: 46px;">
            <img src="https://images2.imgbox.com/09/aa/eHx7k3GG_o.png" alt="language" height="20">
            <i class="material-icons" style="vertical-align: middle; margin-top: 0px; margin-left: 1px; margin-right: -7px; color: #9e9e9e; font-size: 22px;">keyboard_arrow_down</i>
        </a>

        <a href="/" class="pull-right nav-item" style="margin-right: 55px;">
            <img src="https://images2.imgbox.com/31/a2/Elk9kGFA_o.png" alt="search" height="21">
        </a>
    </div>
</nav>

<nav class="navbar" style="height: 44px; line-height: 44px; font-size: 16px;">
    <div style="max-width: 1260px; margin: auto; padding-left: 7px; padding-right: 12px;">
        <div class="dropdown" style="display: inline-block; padding: 0 15px;">
            <button class="btn-link" type="button" data-toggle="dropdown" style="text-decoration: none; color: white;">動畫</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#" style="color:rgb(93, 93, 226)">最近更新</a></li>
                <li><a class="dropdown-item" href="#" style="color:rgb(93, 93, 226)">每日推薦</a></li>
                <li><a class="dropdown-item" href="#" style="color:rgb(93, 93, 226)">經典系列</a></li>
            </ul>
        </div>

        <div class="dropdown"  style="display: inline-block; padding: 0 15px;">
            <button class="btn-link" type="button" data-toggle="dropdown" style="text-decoration: none; color: white;">漫畫</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                <li><a class="dropdown-item" href="#" style="color:rgb(93, 93, 226)">最近更新</a></li>
                <li><a class="dropdown-item" href="#" style="color:rgb(93, 93, 226)">每日推薦</a></li>
                <li><a class="dropdown-item" href="#" style="color:rgb(93, 93, 226)">經典系列</a></li>
            </ul>
        </div>
        <a href="#" class="" style="text-decoration: none; color: white; padding: 0 15px;">收藏列表</a>
    </div>
</nav>


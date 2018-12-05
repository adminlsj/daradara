<nav class="navbar navbar-default nav-main">
    <div class="container mobile-container">
        <!-- Left Side Of Navbar -->
        <ul style="margin-left: -15px" class="nav navbar-nav vertical-align nav-main-content" >
            <li>
                <a href="{{ url('/') }}" style="margin-right: -10px;">
                    <img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/originals/default_freerider_profile_pic.jpg" style="border: 2px solid white; border-radius: 2px;" width="70px" height="70px">
                </a>
            </li>
            <li class="nav-main-slogan">
                <a style="font-weight: 400;" href="{{ url('/') }}">
                    <div style="font-size: 40px; margin-top:10px; margin-bottom: 10px">{{ config('app.name', 'FreeRider') }}</div>
                    <div style="font-size: 15px; text-align: center; color: #dbdbdb">日本文化 | 自由旅行人</div>
                </a>
            </li>
        </ul>
    </div>
</nav>

<nav style="display: none" class="navbar navbar-default nav-category hidden-xs hidden-sm">
    <div class="container mobile-container">
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul style="margin-left: -30px" class="nav navbar-nav" >
                <li>
                    <a href="{{ url('/') }}">
                        主頁
                    </a>
                </li>
                <li>
                    <a href="{{ url('/') }}">
                        旅行
                    </a>
                </li>
                </li>
                <li>
                    <a href="{{ url('/') }}">
                        日本
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
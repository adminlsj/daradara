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
                    <div style="font-size: 40px; margin-top:9px; margin-bottom: 11px">{{ config('app.name', 'FreeRider') }}</div>
                    <h1 style="font-size: 15px; text-align: center; color: #dbdbdb; margin: 0px">日本文化 | 自由旅行人</h1>
                </a>
            </li>
        </ul>
    </div>
</nav>
<nav class="navbar navbar-default nav-main">
    <div class="container mobile-container">
            <!-- Left Side Of Navbar -->
            <ul style="margin-left: -15px" class="nav navbar-nav vertical-align hidden-xs hidden-sm" >
                <li>
                    <a href="{{ url('/') }}" style="margin-right: -10px;">
                        <img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/originals/default_freerider_profile_pic.jpg" style="border: 2px solid white; border-radius: 2px; margin-top: -10px; margin-bottom: -8px" width="100px" height="100px">
                    </a>
                </li>
                <li class="hidden-xs hidden-sm">
                    <a style="font-size: 50px; font-weight: 400;" href="{{ url('/') }}">{{ config('app.name', 'FreeRider') }}</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul style="background-color: gray; margin-left:0px; margin-right: 0px;" class="nav navbar-nav navbar-right">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Navbar -->
                <ins class="adsbygoogle hidden-xs hidden-sm"
                     style="display:inline-block;width:50vw;height:90px"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="1745786231"></ins>
                <ins class="adsbygoogle visible-xs-block visible-sm-block"
                     style="display:inline-block;width:100%;height:90px"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="1745786231"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
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
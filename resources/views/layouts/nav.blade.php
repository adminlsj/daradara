<nav class="navbar navbar-default nav-main">
    <div class="container mobile-container">
        <ul style="margin-left: -15px" class="nav navbar-nav vertical-align nav-main-content" >
            <li>
                <a href="{{ route('blog.genre.show', ['genre' => 'travel', 'category' => $category]) }}" style="margin-right: -10px;">
                    <img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/originals/{{ $category == 'lollipop' ? 'default_lollipop_profile_pic.jpg' : 'default_freerider_profile_pic.jpg'}}" style="border: 2px solid white; border-radius: 2px;" width="70px" height="70px">
                </a>
            </li>
            <li class="nav-main-slogan">
                <a style="font-weight: 400;" href="{{ route('blog.genre.show', ['genre' => 'travel', 'category' => $category]) }}">
                    <div style="font-size: 40px; margin-top:9px; margin-bottom: 11px">{{ $category == 'lollipop' ? 'Lollipop' : config('app.name', 'FreeRider') }}</div>
                    <h1 style="font-size: 15px; text-align: center; color: #dbdbdb; margin: 0px">{{ App\Blog::$pages[$category]['nav'] }}</h1>
                </a>
            </li>
        </ul>
        <ul style="{{ $category == 'japanews' ? 'display: none' : '' }}" class="text-right sidenav-btn">
            <li>
                <span style="color:white; font-size:30px;cursor:pointer;" onclick="openNav()">&#9776;</span>
            </li>
        </ul>
    </div>
</nav>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a style="color: white" href="#">旅遊</a>
    <a class="text-center" href="{{ route('blog.genre.show', ['genre' => 'travel', 'category' => 'japan']) }}">日本</a>
    <a style="color: white" href="#">科技</a>
    <a class="text-center" href="{{ route('blog.genre.show', ['genre' => 'tech', 'category' => 'news']) }}">時事</a>
    <a style="color: white" href="#">流行</a>
    <a class="text-center" href="{{ route('blog.genre.show', ['genre' => 'daily', 'category' => 'lollipop']) }}">時事</a>
</div>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>

<nav class="navbar-bottom navbar-default">
    <div class="fb-share-container">
        <div style="margin-top: -1px;" class="fb-page" data-href="https://www.facebook.com/{{ App\Blog::$pages[$category]['name'] }}" data-tabs="timeline" data-width="500" data-height="72" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/{{ App\Blog::$pages[$category]['name'] }}" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/{{ App\Blog::$pages[$category]['name'] }}">FreeRider {{ App\Blog::$pages[$category]['name'] }}</a></blockquote></div>

        <div style="position: absolute; top: 38px; right: 2rem">
            @if (Request::is('*/*/*') || Request::is('blog/*'))
                <div data-href="https://www.freeriderhk.com/{{ App\Blog::$pages[$current_blog->category]['genre'] }}/{{ $current_blog->category }}/{{ $current_blog->id }}/" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="nav-bottom-share-btn" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.freeriderhk.com/{{ App\Blog::$pages[$current_blog->category]['genre'] }}/{{ $current_blog->category }}/{{ $current_blog->id }}/&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">{{ $category == 'japanews' ? 'Share Post' : '分享貼文' }}</a></div>
            @else
                <div data-href="https://www.freeriderhk.com" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a class="nav-bottom-share-btn" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.freeriderhk.com/&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">{{ $category == 'japanews' ? 'Share' : '分享' }}</a></div>
            @endif
        </div>
    </div>
</nav>
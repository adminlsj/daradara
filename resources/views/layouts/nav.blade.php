<div style="position:absolute; top: 6%; right: 10%;z-index: 999; display:{{ Request::is('/') ? '' : 'none' }}" class="home-nav hidden-xs">
    @guest
        <a href="{{ route('login') }}">登入</a>
        <a href="{{ route('register') }}">註冊</a>
        <a href="{{ route('blog.index') }}">指南</a>
    @else
        <a href="{{ route('user.savedJobsIndex', ['user' => auth()->user()]) }}">儲存職位</a>
        <a href="{{ route('app.index') }}">我的應聘</a></li>
        <a href="{{ route('resume.edit', ['resume' => auth()->user()->resume->id]) }}">我的簡歷</a>
        <a href="{{ route('user.edit', ['user' => auth()->user()]) }}" style="padding-left: 8px; padding-right: 7px">
            <img src="https://s3.amazonaws.com/twobayjobs/avatars/thumbnails/{{ Auth::user()->avatar->filename }}.jpg" class="img-circle" style="margin-top: -10px; margin-bottom: -8px" width="35px" height="35px">&nbsp;
            {{ Auth::user()->name }}
        </a>
        <a href="{{ route('blog.index') }}">部落格</a>
    @endguest
</div>
<nav style="display:{{ Request::is('/') ? 'none' : '' }};" class="{{ Request::is('/') ? 'home-nav-scroll-show' : '' }} navbar navbar-default navbar-fixed-top">
    <div class="container" style="width: 95%">
        <div class="navbar-header">
            <div class="row">
                <div class="col-xs-2 visible-xs-block visible-sm-block" style="margin: 0">
                    <a href="{{ url('/') }}">
                        <img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/thumbnails/default_freerider_profile_pic.jpg" style="border-radius: 2px; margin-top: 7px" width="35px" height="35px">
                    </a>
                </div>
                <div class="col-xs-8 visible-xs-block" style="display: inline; margin-top: 7px; margin-left: -10px; margin-right: 10px">
                    <form action="{{ route('job.search') }}" method="GET">
                        <div class="row">
                            <div class="col-xs-7" style="width: 80%">
                                <div class="form-group">
                                    <input style="box-shadow: none; border-radius: 2px; font-weight: 300" name="title" type="text" value="{{ request('title') }}" class="form-control" placeholder="幫您挑選兩岸好工作 . . .">
                                </div>
                            </div>
                            <div class="col-xs-5" style="width: 70px; margin-left: -25px">
                                <button style="box-shadow: none; border-radius: 2px;" type="submit" class="btn btn-default form-control"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-2">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav hidden-xs hidden-sm" >
                <li>
                    <a href="{{ url('/') }}" style="margin-right: -20px;">
                        <img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/thumbnails/default_freerider_profile_pic.jpg" style="border-radius: 2px; margin-top: -10px; margin-bottom: -8px" width="35px" height="35px">
                    </a>
                </li>
                <li>
                    <a style="font-size: 25px; font-weight: 300;" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
                </li>
                <li>
                    <form class="navbar-form" action="{{ route('job.search') }}" method="GET">
                        <div class="form-group">
                            <input style="box-shadow: none; border-radius: 2px; font-weight: 300" name="title" type="text" class="form-control" placeholder="幫您挑選兩岸好工作 . . .">
                        </div>
                        <button style="box-shadow: none; border-radius: 2px;" type="submit" class="btn btn-default form-control"><i class="glyphicon glyphicon-search"></i></button>
                    </form>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">登入</a></li>
                    <li><a href="{{ route('register') }}">註冊</a></li>
                    <li><a href="{{ route('blog.index') }}">指南</a></li>
                @else
                    <li><a href="{{ route('user.savedJobsIndex', ['user' => auth()->user()]) }}">儲存職位</a></li>
                    <li><a href="{{ route('app.index') }}">我的應聘</a></li>
                    <li><a href="{{ route('resume.edit', ['resume' => auth()->user()->resume->id]) }}">我的簡歷</a></li>
                    <li>
                        <a href="{{ route('user.edit', ['user' => auth()->user()]) }}" style="padding-left: 13px; padding-right: 15px">
                            <img src="https://s3.amazonaws.com/twobayjobs/avatars/thumbnails/{{ Auth::user()->avatar->filename }}.jpg" class="img-circle" style="margin-top: -10px; margin-bottom: -8px" width="35px" height="35px">&nbsp;
                            {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li><a href="{{ route('blog.index') }}">部落格</a></li>
                    <li class="hidden-xs hidden-sm">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            登出
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
    @if (URL::current() == route('job.search'))
        <div>@include('job.search-top')</div>
    @endif
</nav>
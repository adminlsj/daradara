@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5;">

		<div class="paravi-padding-setup" style="padding-top: 20px; padding-bottom: 20px; background-color: #F9F9F9">
			<img class="lazy" style="float:left; border-radius: 50%; width: 70px; height: 70px;" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
			@if (Auth::check() && $user->id == Auth::user()->id)
        <form style="width:auto; height: auto; font-size: 1em; margin-top: 9px;" id="logout-form" action="{{ route('logout') }}" method="POST" class="pull-right">
            {{ csrf_field() }}
            <button style="background-color: inherit !important; color: #d84b6b" class="btn btn-info" type="submit">登出</button>
        </form>
				<a style="width:auto; height: auto; font-size: 1em; margin-top: 9px; margin-right: 5px; color: white" class="btn btn-info pull-right" href="{{ route('user.userEditUpload', $user) }}">上傳影片</a>
			@endif
			<div style="height: 70px; margin-left: 80px">
				<div style="font-size: 1.5em">{{ $user->name }}</div>
				<div style="color: gray">{{ $subscribers }} 位訂閱者</div>
			</div>

      <!-- Tab links -->
      <div class="user-show-tab">
        <button class="user-show-tablinks" onclick="openCity(event, 'London')" id="defaultOpen">首頁</button>
        <button class="user-show-tablinks" onclick="openCity(event, 'Paris')">播放清單</button>
        <button class="user-show-tablinks" onclick="openCity(event, 'Tokyo')">簡介</button>
      </div>
		</div>

    <!-- Tab content -->
    <div id="London" class="user-show-tabcontent">
      <div class="explore-slider-title paravi-padding-setup">
          <h4>上傳的影片</h4>
      </div>
      @if ($videos != null)
        <div class="row no-gutter load-more-container">
          <div class="video-sidebar-wrapper">
              <div id="sidebar-results"><!-- results appear here --></div>
              <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
          </div>
        </div>
      @endif
    </div>

    <div id="Paris" class="user-show-tabcontent">
      <div class="explore-slider-title paravi-padding-setup">
          <h4>已建立的播放清單</h4>
      </div>
      @if ($watches->count() != 0)
        <div class="row paravi-padding-setup user-show-playlist">
          @foreach ($watches as $watch)
            <div class="col-xs-6 col-sm-3 col-md-3 hover-opacity-all load-more-wrapper" style="position: relative;">
                <a style="text-decoration: none; color: black" href="{{ route('video.playlist') }}?list={{ $watch->id }}">
                  <img style="width: 100%; height: 100%;" src="{{ $watch->videos()->first() ? $watch->videos()->first()->imgurH() : 'https://i.imgur.com/JMcgEkPl.jpg' }}" alt="{{ $watch->title }}">
                  <span>
                    <div style="margin: 0;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                      <div>{{ $watch->videos()->count() }}</div>
                      <i style="font-size: 1.6em; margin-right: -2px" class="material-icons">playlist_play</i>
                    </div>
                  </span>

                  <div class="hover-underline">
                    <h4 style="font-size: 0.95em; margin-top: 7px; color: #222222; padding-right: 10px" class="text-ellipsis">{{ $watch->title }}</h4>
                  </div>
                </a>
            </div>
          @endforeach
        </div>
      @endif
    </div>

    <div id="Tokyo" class="user-show-tabcontent">
      <div class="explore-slider-title paravi-padding-setup">
          <h4>用戶簡介</h4>
      </div>
      <div class="paravi-padding-setup">
        <div>用戶名稱：{{ $user->name }}</div>
        <div>電郵地址：[***僅該用戶可查看***]</div>
      </div>
    </div>
	</div>
</div>

<script>
  function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("user-show-tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("user-show-tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }
  document.getElementById("defaultOpen").click();
</script>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection
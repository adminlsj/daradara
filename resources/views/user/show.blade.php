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
				<a style="width:auto; height: auto; font-size: 1em; margin-top: 9px; margin-right: 5px;" class="btn btn-info pull-right" data-toggle="modal" data-target="#uploadVideoModal">上傳影片</a>
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
        <div class="row no-gutter paravi-padding-setup">
          @foreach ($watches as $watch)
            <div class="col-xs-6 col-sm-3 col-md-3 hover-opacity load-more-wrapper">
                <a style="text-decoration: none; color: black" href="{{ route('video.playlist') }}?list={{ $watch->id }}">
                <img style="width: 100%; height: 100%;" src="{{ $watch->videos()->first() ? $watch->videos()->last()->imgurH() : '' }}" alt="{{ $watch->title }}">

                <div class="hover-underline">
                    <h4 style="font-size: 0.95em; margin-top: 7px; color: #222222;" class="text-ellipsis">{{ $watch->title }}【{{ $watch->videos()->count()}} 部影片】</h4>
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

<div class="modal" id="uploadVideoModal" tabindex="-1" role="dialog" aria-labelledby="uploadVideoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <form action="{{ route('email.userStartUpload') }}" method="GET">

      <div style="padding: 15px;" class="modal-content">
        <div style="border: 0px; position: relative;" class="modal-header">
          <h4 style="color: gray;font-weight: 100; transform: rotate(45deg);position: absolute; font-size: 3em; top: -10px; cursor: pointer;" class="no-select" data-dismiss="modal">+</h4>
          <h4 style="color: #3F3F3F; margin-bottom: 0px; margin-top: 40px; font-size: 1.7em" class="modal-title" id="uploadVideoModalLabel">上傳影片</h4>
        </div>
        <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
          <div>將影片提交至 LaughSeeJapan 即代表您瞭解並同意 LaughSeeJapan 的《<a href="/terms">服務條款</a>》和《<a href="/policies">社群規範</a>》。</div>
          <div style="margin-top: 15px;">請勿侵犯其他使用者的版權或隱私權。 <a href="/copyright">瞭解詳情</a></div>

          <div style="text-align: center;">
            <button style="height: 45px; margin-top: 20px; font-size: 1em; margin-bottom: 10px; width: auto;" type="submit" class="btn btn-info" name="submit">開始上傳影片</button>
          </div>
        </div>
      </div>

    </form>

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
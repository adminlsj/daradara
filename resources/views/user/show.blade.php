@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5;" class="padding-setup">

		<div style="padding: 10px 0px;">
			<img class="lazy" style="float:left; border-radius: 50%; width: 70px; height: 70px;" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
			@if ($user->id == Auth::user()->id)
				<a style="width:auto; height: auto; font-size: 1em; margin-top: 9px;" class="btn btn-info pull-right" data-toggle="modal" data-target="#uploadVideoModal">上傳影片</a>
			@endif
			<div style="height: 70px; margin-left: 80px">
				<div style="font-size: 1.5em">{{ $user->name }}</div>
				<div style="color: gray">{{ $watches->count() }} 個頻道</div>
			</div>
		</div>

		<div style="font-size: 1em; margin-bottom: 10px; font-weight: 500; border-bottom: solid black 2px; width: 70px; text-align: center; line-height: 35px">所有頻道</div>

		@if ($watches->count() != 0)
			@foreach ($watches as $watch)
				<a href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}" style="text-decoration: none;">
					<div class="col-xs-1" style="width: 70px; margin: 0px; padding: 0px; text-align: center; margin-right: 15px; margin-bottom: 10px;">
						<img class="lazy" style="width: 100%; height: auto;" src="{{ $watch->imgurDefaultCircleB() }}" data-src="{{ $watch->imgurB() }}" data-srcset="{{ $watch->imgurB() }}" alt="{{ $watch->title }}">
						<div class="text-ellipsis" style="width: 100%; font-size: 0.8em; padding-top: 5px; color: #595959;">{{ $watch->title }}</div>
					</div>
				</a>
			@endforeach
		@endif

		@if (Auth::check() && Auth::user()->id == $user->id)
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
		        {{ csrf_field() }}
		        <button type="submit">登出</button>
		    </form>
		@endif
	</div>
</div>

<div class="modal" id="uploadVideoModal" tabindex="-1" role="dialog" aria-labelledby="uploadVideoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <form action="{{ route('email.userUploadVideo') }}" method="GET">

      <div style="padding: 15px;" class="modal-content">
        <div style="border: 0px; position: relative;" class="modal-header">
          <h4 style="color: gray;font-weight: 100; transform: rotate(45deg);position: absolute; font-size: 3em; top: -10px; cursor: pointer;" class="no-select" data-dismiss="modal">+</h4>
          <h4 style="color: #3F3F3F; margin-bottom: 0px; margin-top: 40px; font-size: 1.7em" class="modal-title" id="uploadVideoModalLabel">上傳影片</h4>
        </div>
        <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
          <div>請填寫上傳影片的基本資料：</div>

          <div class="form-group" style="margin-top: 20px;">
            <input type="text" class="form-control" name="channel-genre" id="channel-genre" placeholder="頻道類型" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="channel-category" id="channel-category" placeholder="頻道標題" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="video-title" id="video-title" placeholder="影片標題" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="video-description" id="video-description" placeholder="說明">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="video-image" id="video-image" placeholder="縮圖鏈結" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="video-link" id="video-link" placeholder="影片鏈結" required>
          </div>

          <button style="height: 45px; margin-top: 10px; font-size: 1em; margin-bottom: 20px" type="submit" class="btn btn-info" name="submit">儲存</button>

          <div style="font-size: 0.8em; color: gray; font-weight: 300">將影片提交至 LaughSeeJapan 即代表您瞭解並同意 LaughSeeJapan 的《<a href="/policy">服務條款</a>》和《<a href="/policy">社群規範</a>》。</div>
		  <div style="font-size: 0.8em; color: gray; font-weight: 300; margin-top:5px;">請勿侵犯其他使用者的版權或隱私權。 <a href="/policy">瞭解詳情</a></div>
        </div>
      </div>

    </form>

  </div>
</div>

@endsection
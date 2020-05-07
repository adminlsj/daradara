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

		<div class="paravi-padding-setup user-show-general-panel" style="padding-top: 20px; padding-bottom: 20px; background-color: #F9F9F9">
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

      <div class="user-show-tab">
        <a href="{{ route('user.show', [$user, 'featured']) }}" class="user-show-tablinks">首頁</a>
        <a href="{{ route('user.show', [$user, 'videos']) }}" class="user-show-tablinks">影片</a>
        <a style="width: 100px;" href="{{ route('user.show', [$user, 'playlists']) }}" class="user-show-tablinks">播放清單</a>
        <a href="{{ route('user.show', [$user, 'about']) }}" class="user-show-tablinks active">簡介</a>
      </div>
		</div>

    <div class="paravi-padding-setup">
      <div>用戶名稱：{{ $user->name }}</div>
      <div>電郵地址：[***僅該用戶可查看***]</div>
    </div>
  </div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection
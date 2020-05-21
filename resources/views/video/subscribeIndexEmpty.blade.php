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
		<div style="padding: 20px; padding-bottom: 25px;">
			<i style="font-size: 85px; color: gray; float: left; margin-left: -5px;" class="material-icons">subscriptions</i>
			<div style="margin-left: 90px; margin-top: 3px; height: 76px">
				<div style="font-size: 1.5em; font-weight: bold">讓頻道訂閱信息更充實</div>
				<div style="color: gray; font-weight: bold">訂閱您喜愛的頻道，保證不會錯過最新內容。</div>
			</div>
		</div>
		@include('video.home-default')
	</div>
</div>
@endsection
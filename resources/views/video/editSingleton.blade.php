@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content" id="uploadVideoModal">
	<div style="background-color: #F5F5F5;" class="paravi-padding-setup">
		<br>
		<form action="{{ route('video.uploadSingleton') }}" method="POST" enctype="multipart/form-data">
		  {{ csrf_field() }}
		  <div class="row">
		  	<div class="col-md-6">
		        <div style="color: #3F3F3F; font-weight: 500; font-size: 1.1em;">
		        	<div class="row">
		        		<div class="col-md-3" style="padding-right: 8px;">
		        			<div class="form-group" >
						        <input type="number" class="form-control" name="video-id" id="video-id" placeholder="Video id" required>
					        </div>
		        		</div>
		        		<div class="col-md-3" style="padding-right: 8px; padding-left: 8px;">
		        			<div class="form-group">
						        <input type="number" class="form-control" name="episodes" id="episodes" placeholder="Episodes" required>
					        </div>
		        		</div>
		        		<div class="col-md-3" style="padding-right: 8px; padding-left: 8px;">
		        			<div class="form-group">
						        <input type="number" class="form-control" name="user-id" id="user-id" placeholder="User id" required>
					        </div>
		        		</div>
		        		<div class="col-md-3" style="padding-left: 8px;">
		        			<div class="form-group">
						        <input type="number" class="form-control" name="playlist-id" id="playlist-id" placeholder="Playlist id" required>
					        </div>
		        		</div>
		        	</div>

		        	<div class="row">
		        		<div class="col-md-6" style="padding-right: 8px;">
		        			<div class="form-group">
						        <input type="text" class="form-control" name="title" id="title" placeholder="標題" required>
					        </div>
		        		</div>
		        		<div class="col-md-6" style="padding-left: 8px;">
		        			<div class="form-group">
						        <input type="text" class="form-control" name="created-at" id="created-at" placeholder="首播日期" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}" required>
					        </div>
		        		</div>
		        	</div>

		          <div class="form-group">
		            <input type="text" class="form-control" name="tags" id="tags" placeholder="標籤（各標籤之間請預留空格）" required>
		          </div>

		          <div class="form-group">
		            <textarea style="border: 0.5px solid #e9e9e9; -webkit-appearance: none; box-shadow: inset 0px 0px 0px 0px red;" class="form-control" name="images" id="images" rows="13" placeholder="圖片鏈結"></textarea>
		          </div>

		          <div style="margin-right:100px; position: relative;" class="form-group">
		            <input type="text" class="form-control" name="link" id="link" placeholder="影片崁入鏈結">
		            <div id="test-play-singleton-btn" style="width: 103px; position: absolute; top: 0px; right:-100px; background-color: #D5D5D5; color: #666666; border-color: #D5D5D5; cursor: pointer; height: 45px; line-height: 45px; text-align: center; border-top-right-radius: 3px; border-bottom-right-radius: 3px;">測試播放</div>
		          </div>

		          <button id="singleNewCreateBtn" style="height: 45px; font-size: 1em; margin-bottom: 15px; width: 103px; background-color: red !important; border: none;" type="submit" class="btn btn-info">發佈</button>

		        </div>
		  	</div>

		  	<div class="col-md-6">
		  		<div id="test-player" class="aspect-ratio" style="background-color: black; background-image: url('https://i.imgur.com/TcZjkZa.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px;">
				</div>
				<div style="margin-top: 15px; margin-bottom: 15px;">
				  <label class="switch">
					<input type="checkbox" name="outsource" id="outsource" checked=checked>
					<span class="slider round"></span>
				  </label>
				  <div class="embed-video-switch-text">崁入影片<small style="font-weight: normal; font-size: 0.8em">（<a href="/about">崁入指南</a>及<a href="/policies">社群規範</a>）</small></div>
			    </div>
		  	</div>
		  </div>

		</form>
	</div>
</div>

@endsection
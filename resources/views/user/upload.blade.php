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
		<div class="subscribes-tab">
	    	<a class="load-tag-videos" onclick="openCity(event, '上傳影片')" id="defaultOpen" style="margin-right: 5px;">崁入影片</a>
			<a class="load-tag-videos" onclick="openCity(event, '創建頻道')" style="margin-right: 5px;">建立播放清單</a>
			<a href="/about" class="load-tag-videos" style="margin-right: 5px;">崁入指南</a>
			<a href="/policies" class="load-tag-videos" style="margin-right: 5px;">社群規範</a>
		</div>
		<div class="paravi-padding-setup">

			<div id="上傳影片" class="user-upload-tabcontent">
			  <form id="singleNewCreateForm" action="{{ route('user.userUpdateUpload', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">

				  {{ csrf_field() }}
				  <input id="type" name="type" type="hidden" value="video">
			  	  <input id="duration" name="duration" type="hidden" value="">
				  <input type="hidden" name="created_at" id="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}">
				  <input type="hidden" name="uploaded_at" id="uploaded_at" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}">

				  <div class="row" id="uploadVideoModal">
				  	<div class="col-md-6">
				        <div style="color: #3F3F3F; font-weight: 500; font-size: 1.1em;">
				          <div class="form-group">
						    <select style="border: 0.5px solid #e9e9e9; -webkit-appearance: none; box-shadow: inset 0px 0px 0px 0px red; height: 45px;" class="form-control" name="channel" id="channel">
							    <option value="">選擇播放清單...</option>
							    @foreach ($watches as $watch)
							       <option value="{{ $watch->id }}">{{ $watch->title }}</option>
							    @endforeach
						    </select>
						  </div>
				          <div class="form-group">
				            <input type="text" class="form-control" name="title" id="title" placeholder="標題（必填）" required>
				          </div>
				          <div class="form-group">
				            <textarea style="border: 0.5px solid #e9e9e9; -webkit-appearance: none; box-shadow: inset 0px 0px 0px 0px red;" class="form-control" name="description" id="description" rows="5" placeholder="簡介"></textarea>
				          </div>

				          <div class="form-group">
				            <input type="text" class="form-control" name="tags" id="tags" placeholder="標籤（各標籤之間請預留空格）" required>
				          </div>

				          <div style="margin-right:100px; position: relative;" class="form-group">
				            <input type="text" class="form-control" name="link" id="link" placeholder="影片崁入鏈結" required onkeyup="$('#test-play-btn').click()">
				            <div id="test-play-btn" style="width: 103px; position: absolute; top: 0px; right:-100px; background-color: #D5D5D5; color: #666666; border-color: #D5D5D5; cursor: pointer; height: 45px; line-height: 45px; text-align: center; border-top-right-radius: 3px; border-bottom-right-radius: 3px;">測試播放</div>
				          </div>

						  <div style="margin-right:100px; position: relative;" class="form-group">
				            <input style="background-color: white" readonly="readonly" type="text" class="form-control" name="file-text" id="file-text" placeholder="上傳影片縮圖" required>
				            <label class="upload-image-btn" style="border-top-right-radius: 3px; border-bottom-right-radius: 3px;">
							    <input type="file" name="image" id="image" accept="image/*" required>
							    <span style="color: #666666; font-weight: 500;">選擇圖片</span>
							</label>
				          </div>

				          <button id="singleNewCreateBtn" style="height: 45px; font-size: 1em; margin-bottom: 15px; width: 103px; background-color: red !important; border: none;" type="submit" class="btn btn-info">發佈</button>

				          <div style="font-size: 0.8em; color: gray; font-weight: normal;">發佈影片即代表您瞭解並同意 LaughSeeJapan 的《<a href="/terms">服務條款</a>》和《<a href="/policies">社群規範</a>》。</div>
						  <div style="font-size: 0.8em; color: gray; font-weight: normal; margin-top:5px; margin-bottom: 15px">請勿侵犯其他使用者的版權或隱私權。 <a href="/copyright">瞭解詳情</a></div>
				        </div>
				  	</div>

				  	<div class="col-md-6">
				  		<div id="test-player" class="aspect-ratio" style="background-color: black; background-image: url('https://i.imgur.com/wgOXAy6.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px;">
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

			<div id="創建頻道" class="user-upload-tabcontent">
			  <form action="{{ route('user.userUpdateUpload', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">
			  	  {{ csrf_field() }}
			  	  <input id="type" name="type" type="hidden" value="playlist">

			      <div class="row" id="uploadPlaylistModal">
			      	<div class="col-md-12">
				        <div style="color: #3F3F3F; font-weight: 500; font-size: 1.1em">
				          <div class="form-group">
				            <input type="text" class="form-control" name="title" id="title" placeholder="標題（必填）" required>
				          </div>
				          <div class="form-group">
				            <textarea style="border: 0.5px solid #e9e9e9; -webkit-appearance: none; box-shadow: inset 0px 0px 0px 0px red;" class="form-control" name="description" id="description" rows="5" placeholder="簡介" required></textarea>
				          </div>

				          <button style="height: 45px; font-size: 1em; margin-bottom: 15px; width: 103px; background-color: red !important; border: none;" type="submit" class="btn btn-info">建立</button>

				          <div style="font-size: 0.8em; color: gray; font-weight: normal;">發佈影片即代表您瞭解並同意 LaughSeeJapan 的《<a href="/terms">服務條款</a>》和《<a href="/policies">社群規範</a>》。</div>
						  <div style="font-size: 0.8em; color: gray; font-weight: normal; margin-top:5px;">請勿侵犯其他使用者的版權或隱私權。 <a href="/copyright">瞭解詳情</a></div>
				        </div>
				      </div>
				    </div>
			    </form>
			</div>
		</div>
	</div>
</div>

<script>
	function openCity(evt, cityName) {
	  // Declare all variables
	  var i, tabcontent, tablinks;

	  // Get all elements with class="tabcontent" and hide them
	  tabcontent = document.getElementsByClassName("user-upload-tabcontent");
	  for (i = 0; i < tabcontent.length; i++) {
	    tabcontent[i].style.display = "none";
	  }

	  // Get all elements with class="tablinks" and remove the class "active"
	  tablinks = document.getElementsByClassName("user-upload-tablinks");
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
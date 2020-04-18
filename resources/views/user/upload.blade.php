@extends('layouts.app')

@section('nav')
<<<<<<< HEAD
	@include('layouts.nav-main-original', ['theme' => 'white'])
=======
	@include('nav.top')
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
<<<<<<< HEAD
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div class="paravi-padding-setup" style="background-color: #F5F5F5; min-height: calc(100vh - 50px);">
=======
    @include('nav.side')
</div>

<div class="main-content">
	<div class="paravi-padding-setup" style="background-color: #F5F5F5;">
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
		<!-- Tab links -->
		<div class="user-upload-tab" style="margin-left: 15px; padding-top: 25px; margin-bottom: -10px">
		  <button class="user-upload-tablinks" onclick="openCity(event, '創建頻道')">播放清單</button>
		  <button class="user-upload-tablinks" onclick="openCity(event, '上傳影片')" style="margin-left: 15px" id="defaultOpen">上傳影片</button>
		</div>

		<!-- Tab content -->
		<div id="創建頻道" class="user-upload-tabcontent">
<<<<<<< HEAD
		  <form action="{{ route('user.userUpdateUpload', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">
=======
		  <form action="{{ route('playlist.store', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
		  	  {{ csrf_field() }}
		  	  <input id="type" name="type" type="hidden" value="playlist">

		      <div style="padding: 0px;">
		        <div style="border: 0px; position: relative;" class="modal-header">
		          <h4 style="color: #3F3F3F; margin-bottom: 0px; font-size: 1.7em" class="modal-title">新增播放清單</h4>
		        </div>
		        <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
		          <div>請填寫播放清單的基本資料：</div>

		          <div class="form-group" style="margin-top: 20px;">
		            <input type="text" class="form-control" name="title" id="title" placeholder="標題" required>
		          </div>
		          <div class="form-group">
		            <textarea class="form-control" name="description" id="description" rows="3" placeholder="簡介" required></textarea>
		          </div>

		          <button style="height: 45px; margin-top: 5px; font-size: 1em; margin-bottom: 20px" type="submit" class="btn btn-info" name="submit">建立播放清單</button>

		          <div style="font-size: 0.8em; color: gray; font-weight: 300">將影片提交至 LaughSeeJapan 即代表您瞭解並同意 LaughSeeJapan 的《<a href="/terms">服務條款</a>》和《<a href="/policies">社群規範</a>》。</div>
				  <div style="font-size: 0.8em; color: gray; font-weight: 300; margin-top:5px;">請勿侵犯其他使用者的版權或隱私權。 <a href="/copyright">瞭解詳情</a></div>
		        </div>
		      </div>

		    </form>
		</div>

		<div id="上傳影片" class="user-upload-tabcontent">
<<<<<<< HEAD
		  <form id="singleNewCreateForm" action="{{ route('user.userUpdateUpload', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">
=======
		  <form id="singleNewCreateForm" action="{{ route('video.store', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c

			  {{ csrf_field() }}
			  <input id="type" name="type" type="hidden" value="video">
		  	  <input id="duration" name="duration" type="hidden" value="">
			  <input type="hidden" name="created_at" id="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}">
			  <input type="hidden" name="uploaded_at" id="uploaded_at" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}">

		      <div style="padding: 0px;">
		        <div style="border: 0px; position: relative;" class="modal-header">
		          <h4 style="color: #3F3F3F; margin-bottom: 0px; font-size: 1.7em" class="modal-title" id="uploadVideoModalLabel">上傳影片</h4>
		        </div>
		        <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
		          <div>請填寫上傳影片的基本資料：</div>

		          <div class="form-group" style="margin-top: 20px;">
				    <select class="form-control" name="channel" id="channel">
					    <option value="">選擇播放清單...</option>
<<<<<<< HEAD
					    @foreach ($watches as $watch)
					       <option value="{{ $watch->id }}">{{ $watch->title }}</option>
=======
					    @foreach ($playlists as $playlist)
					       <option value="{{ $playlist->id }}">{{ $playlist->title }}</option>
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
					    @endforeach
				    </select>
				  </div>
		          <div class="form-group">
		            <input type="text" class="form-control" name="title" id="title" placeholder="影片標題" required>
		          </div>
		          <div class="form-group">
		            <textarea class="form-control" name="description" id="description" rows="3" placeholder="簡介"></textarea>
		          </div>

		          <div class="form-group">
		            <input type="text" class="form-control" name="tags" id="tags" placeholder="標籤（各標籤之間請預留空格）" required>
		          </div>

<<<<<<< HEAD
		          <div style="margin-right:100px; position: relative; margin-bottom: 0px" class="form-group">
		            <input type="text" class="form-control" name="link" id="link" placeholder="影片崁入鏈結" required>
		            <div id="test-play-btn" style="width: 102px; position: absolute; top: 0px; right:-100px; background-color: gray; color: white; padding: 6px 0px 6px 20px; cursor: pointer;">測試播放</div>
		          </div>
		          <div style="margin-bottom: 20px;">
			          <small style="font-weight: 400; margin-left: 5px; color: #595959;">請參閱在娛見日本 LaughSeeJapan 崁入內容的<a href="/about">指南與守則</a>。</small>
		          </div>
=======
		          <div style="margin-right:100px; position: relative;" class="form-group">
		            <input type="text" class="form-control" name="link" id="link" placeholder="影片崁入鏈結（查看教學：https://tutorialehtml.com/en/html-tutorial-embed-video/）" required>
		            <div id="test-play-btn" style="width: 102px; position: absolute; top: 0px; right:-100px; background-color: gray; color: white; padding: 6px 0px 6px 20px; cursor: pointer;">測試播放</div>
		          </div>
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c

				  <div id="test-player" class="aspect-ratio" style="background-color: black; background-image: url('https://i.imgur.com/TcZjkZa.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px; margin-bottom: 25px; display: none;">
				  </div>

		          <div class="form-group">
				    <h4 style="color: #3F3F3F; margin-bottom: 0px; font-size: 1.7em; padding-bottom: 10px" class="modal-title" id="uploadVideoModalLabel">上傳縮圖&nbsp;<small>(< 2MB)</small></h4>
					<input style="font-size:1em" type="file" name="image" id="image" accept="image/*" required>
				  </div>

		          <button id="singleNewCreateBtn" style="height: 45px; margin-top: 10px; font-size: 1em; margin-bottom: 20px" type="submit" class="btn btn-info">上傳影片</button>

		          <div style="font-size: 0.8em; color: gray; font-weight: 300">將影片提交至 LaughSeeJapan 即代表您瞭解並同意 LaughSeeJapan 的《<a href="/terms">服務條款</a>》和《<a href="/policies">社群規範</a>》。</div>
				  <div style="font-size: 0.8em; color: gray; font-weight: 300; margin-top:5px;">請勿侵犯其他使用者的版權或隱私權。 <a href="/copyright">瞭解詳情</a></div>
		        </div>
		      </div>

		    </form>
		</div>
		<br>
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
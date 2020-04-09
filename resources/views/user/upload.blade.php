@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div class="paravi-padding-setup" style="background-color: #F5F5F5;">
		<!-- Tab links -->
		<div class="user-upload-tab">
		  <button class="user-upload-tablinks" onclick="openCity(event, '創建頻道')" id="defaultOpen">創建頻道</button>
		  <button class="user-upload-tablinks" onclick="openCity(event, '上傳影片')" style="margin-left: 15px">上傳影片</button>
		</div>

		<!-- Tab content -->
		<div id="創建頻道" class="user-upload-tabcontent">
		  <form action="{{ route('user.userUpdateUpload', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">
		  	  {{ csrf_field() }}
		  	  <input id="type" name="type" type="hidden" value="channel">

		      <div style="padding: 15px;" class="modal-content">
		        <div style="border: 0px; position: relative;" class="modal-header">
		          <h4 style="color: #3F3F3F; margin-bottom: 0px; font-size: 1.7em" class="modal-title">創建頻道</h4>
		        </div>
		        <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
		          <div>請填寫創建頻道的基本資料：</div>

		          <div class="form-group" style="margin-top: 20px;">
		            <input type="text" class="form-control" name="genre" id="genre" placeholder="類型" required>
		          </div>
		          <div class="form-group">
		            <input type="text" class="form-control" name="title" id="title" placeholder="標題" required>
		          </div>
		          <div class="form-group">
		            <textarea class="form-control" name="description" id="description" rows="3" placeholder="簡介" required></textarea>
		          </div>
		          <div class="form-group">
		            <input type="text" class="form-control" name="tags" id="tags" placeholder="標籤（各標籤之間請預留空格）" required>
		          </div>
				  <div class="form-group">
				    <label for="image">上傳封面圖片</label>
					<input style="font-size:0.8em" type="file" name="image" id="image" accept="image/*" required>
				  </div>

		          <button style="height: 45px; margin-top: 5px; font-size: 1em; margin-bottom: 20px" type="submit" class="btn btn-info" name="submit">創建頻道</button>

		          <div style="font-size: 0.8em; color: gray; font-weight: 300">將影片提交至 LaughSeeJapan 即代表您瞭解並同意 LaughSeeJapan 的《<a href="/terms">服務條款</a>》和《<a href="/policies">社群規範</a>》。</div>
				  <div style="font-size: 0.8em; color: gray; font-weight: 300; margin-top:5px;">請勿侵犯其他使用者的版權或隱私權。 <a href="/copyright">瞭解詳情</a></div>
		        </div>
		      </div>

		    </form>
		</div>

		<div id="上傳影片" class="user-upload-tabcontent">
		  <form id="singleNewCreateForm" action="{{ route('user.userUpdateUpload', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">

			  {{ csrf_field() }}
			  <input id="type" name="type" type="hidden" value="video">
		  	  <input id="duration" name="duration" type="hidden" value="">
			  <input type="hidden" name="created_at" id="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}">
			  <input type="hidden" name="uploaded_at" id="uploaded_at" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}">

		      <div style="padding: 15px;" class="modal-content">
		        <div style="border: 0px; position: relative;" class="modal-header">
		          <h4 style="color: #3F3F3F; margin-bottom: 0px; font-size: 1.7em" class="modal-title" id="uploadVideoModalLabel">上傳影片</h4>
		        </div>
		        <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
		          <div>請填寫上傳影片的基本資料：</div>

		          <div class="form-group" style="margin-top: 20px;">
				    <select class="form-control" name="channel" id="channel" required>
				      @if ($watches->first())
					      <option value="">選擇所屬頻道...</option>
					      @foreach ($watches as $watch)
					      	 <option value="{{ $watch->title }}">{{ $watch->title }}</option>
					      @endforeach
					  @else
						  <option value="">請先創建頻道...</option>
				      @endif
				    </select>
				  </div>
		          <div class="form-group">
		            <input type="text" class="form-control" name="title" id="title" placeholder="影片標題" required>
		          </div>
		          <div class="form-group">
		            <textarea class="form-control" name="description" id="description" rows="3" placeholder="簡介" required></textarea>
		          </div>
		          <div class="form-group">
		            <input type="text" class="form-control" name="link" id="link" placeholder="影片鏈結（填寫影片現存的鏈結）" required>
		          </div>
		          <div class="form-group">
		            <input type="text" class="form-control" name="tags" id="tags" placeholder="標籤（各標籤之間請預留空格）" required>
		          </div>
		          <div class="form-group">
				    <label for="image">上傳封面圖片</label>
					<input style="font-size:0.8em" type="file" name="image" id="image" accept="image/*" required>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.css">
<div style="display: none;" id="dplayer"></div>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/flv.js/dist/flv.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.js"></script>

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
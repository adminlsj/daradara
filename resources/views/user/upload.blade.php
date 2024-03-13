@extends('layouts.app')

@section('nav')
	@include('nav.main')
@endsection

@section('content')

<div style="padding: 68px 34px 0px 34px">
	<div class="subscribes-tab">
    	<a class="load-tag-videos" onclick="openCity(event, '上傳影片')" id="defaultOpen" style="margin-right: 5px;">崁入影片</a>
		<a class="load-tag-videos" onclick="openCity(event, '創建頻道')" style="margin-right: 5px;">建立播放清單</a>
		<a href="/about" class="load-tag-videos" style="margin-right: 5px;">崁入指南</a>
		<a href="/policies" class="load-tag-videos" style="margin-right: 5px;">社群規範</a>
	</div>
	<div class="paravi-padding-setup">

		<div id="上傳影片" class="user-upload-tabcontent">
	      <br>
		  <form id="singleNewCreateForm" action="{{ route('user.userUpdateUpload', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">

			  {{ csrf_field() }}
			  <input id="type" name="type" type="hidden" value="video">
		  	  <input id="duration" name="duration" type="hidden" value="">

			  <div class="row" id="uploadVideoModal">
			  	<div class="col-md-12">
			        <div style="color: #3F3F3F; font-weight: 500; font-size: 1.1em;">
			          <!-- <div class="form-group">
					    <select style="border: 0.5px solid #e9e9e9; -webkit-appearance: none; box-shadow: inset 0px 0px 0px 0px red; height: 45px;" class="form-control" name="channel" id="channel">
						    <option value="">選擇播放清單...</option>
						    @foreach ($watches as $watch)
						       <option value="{{ $watch->id }}">{{ $watch->title }}</option>
						    @endforeach
					    </select>
					  </div> -->
					  <div class="form-group">
			            <input style="width: calc(50% - 7px); display: inline-block; margin-right: 10px;" type="text" class="form-control" name="artist" id="artist" placeholder="用戶名稱" required>
			            <input style="width: calc(50% - 7px);  display: inline-block;" type="text" class="form-control" name="playlist" id="playlist" placeholder="播放清單" required>
			          </div>

			          <div class="form-group">
			            <input style="width: calc(50% - 7px); display: inline-block; margin-right: 10px;" type="text" class="form-control" name="title" id="title" placeholder="中文標題" required>
			            <input style="width: calc(50% - 7px);  display: inline-block;" type="text" class="form-control" name="translations" id="translations" placeholder="日文標題" required>
			          </div>

			          <div class="form-group">
					    <select style="border: 0.5px solid #e9e9e9; -webkit-appearance: none; box-shadow: inset 0px 0px 0px 0px red; height: 45px; width: calc(50% - 7px); display: inline-block; margin-right: 10px;" class="form-control" name="genre" id="genre">
						    <option value="">選擇影片類型...</option>
						    @foreach (App\Video::$genre as $item)
						       <option value="{{ $item }}">{{ $item }}</option>
						    @endforeach
					    </select>
					    <input style="width: calc(50% - 7px);  display: inline-block;" type="text" class="form-control" name="created_at" id="created_at" placeholder="created_at" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}" required>
					  </div>

			          <div class="form-group">
			            <textarea style="border: 0.5px solid #e9e9e9; -webkit-appearance: none; box-shadow: inset 0px 0px 0px 0px red;" class="form-control" name="description" id="description" rows="5" placeholder="簡介"></textarea>
			          </div>

			          <div class="form-group">
			            <input type="text" class="form-control" name="tags" id="tags" placeholder="標籤（各標籤之間請預留空格）" required>
			          </div>

			          <div class="form-group">
			            <input style="width: calc(50% - 7px); display: inline-block; margin-right: 20px;" type="text" class="form-control" name="foreign_sd" id="foreign_sd" placeholder="foreign_sd" required>

						  <input class="form-check-input" style="height: 17px; width: 17px;" type="checkbox" id="tc" name="tc" value="tc" checked>
						  <label class="form-check-label" style="color: white; vertical-align: middle; margin-left: 5px; margin-bottom: 9px;">tc</label>
						  &nbsp;&nbsp;&nbsp;
						  <input class="form-check-input" style="height: 17px; width: 17px;" type="checkbox" id="sc" name="sc" value="sc">
						  <label class="form-check-label" style="color: white; vertical-align: middle; margin-left: 5px; margin-bottom: 9px;">sc</label>
					  </div>

					  <div class="form-group">
						  <div style="margin-right:100px; position: relative; width: calc(50% - 107px); display: inline-block; margin-right: 110px;" class="form-group">
				            <input style="background-color: white" readonly="readonly" type="text" class="form-control" name="file-text" id="file-text" placeholder="上傳影片縮圖" required>
				            <label class="upload-image-btn" style="border-top-right-radius: 3px; border-bottom-right-radius: 3px;">
							    <input type="file" name="image" id="image" accept="image/*" required>
							    <span style="color: #666666; font-weight: 500;">選擇圖片</span>
							</label>
				          </div>
				          <input style="width: calc(50% - 7px); display: inline-block" type="text" class="form-control" name="cover" id="cover" placeholder="cover" value="https://i.imgur.com/E6mSQA2.jpg" required>
			          </div>

			          <button id="singleNewCreateBtn" style="height: 45px; font-size: 1em; margin-bottom: 15px; width: 103px; background-color: red !important; border: none;" type="submit" class="btn btn-info">發佈</button>

			          <div style="font-size: 0.8em; color: gray; font-weight: normal;">發佈影片即代表您瞭解並同意 LaughSeeJapan 的《<a href="/terms">服務條款</a>》和《<a href="/policies">社群規範</a>》。</div>
					  <div style="font-size: 0.8em; color: gray; font-weight: normal; margin-top:5px; margin-bottom: 15px">請勿侵犯其他使用者的版權或隱私權。 <a href="/copyright">瞭解詳情</a></div>
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
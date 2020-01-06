@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/xSMGFWh.png', 'backgroundColor' => '#222222', 'itemsColor' => "white"])
@endsection

@section('content')
	<div style="background-color:#414141; color: white;" class="row mobile-container video-mobile-container">
		<div class="hidden-xs hidden-sm" style="margin-top: 15px;"></div>
		<div class="video-sidebar-wrapper">
			@include('video.singleShowWatch')

			<!-- Tab links -->
			<div style="margin-top: -20px" class="tab">
			  <button class="tablinks" onclick="openList(event, 'Watch')" id="defaultOpen">全集列表</button>
			  <button class="tablinks" onclick="openList(event, 'Related')">相關影片</button>
			</div>

			<!-- Tab content -->
			<div id="Watch" class="tabcontent">
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-format="fluid"
				     data-ad-layout-key="-dq+97-3z-b8+zi"
				     data-ad-client="ca-pub-4485968980278243"
				     data-ad-slot="1056756521"></ins>
				<script>
				     (adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			    @foreach ($videos as $video)
				    <div style="{{ $video->id == $current->id ? 'background-color: #7A7A7A' : '' }}">
				    	@include('video.singleRelatedWatch')
			    	</div>
			    @endforeach
			</div>

			<div id="Related" class="tabcontent">
				@foreach ($related as $video)
			    	@include('video.singleRelatedWatch')
			    @endforeach
			</div>
		</div>
	</div>

	<script>
		function openList(evt, listName) {
		  // Declare all variables
		  var i, tabcontent, tablinks;

		  // Get all elements with class="tabcontent" and hide them
		  tabcontent = document.getElementsByClassName("tabcontent");
		  for (i = 0; i < tabcontent.length; i++) {
		    tabcontent[i].style.display = "none";
		  }

		  // Get all elements with class="tablinks" and remove the class "active"
		  tablinks = document.getElementsByClassName("tablinks");
		  for (i = 0; i < tablinks.length; i++) {
		    tablinks[i].className = tablinks[i].className.replace(" active", "");
		  }

		  // Show the current tab, and add an "active" class to the button that opened the tab
		  document.getElementById(listName).style.display = "block";
		  evt.currentTarget.className += " active";
		}

		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();
	</script>
@endsection
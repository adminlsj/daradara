@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
  @include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/xSMGFWh.png', 'backgroundColor' => '#282828', 'itemsColor' => 'white', 'menuBtnColor' => 'white'])
@endsection

@section('content')
    <div class="hidden-sm hidden-xs sidebar-menu">
      @include('video.sidebarMenu', ['theme' => 'dark'])
    </div>

    <div class="main-content">
		<div style="background-color:#1F1F1F; color: white;">
			<div class="video-sidebar-wrapper">
				<div class="row">
					<div class="col-md-8 single-show-player">
						@include('video.singleShowWatch')
					</div>

					<div class="col-md-4 single-show-list">
						<br class="hidden-sm hidden-xs">
						<!-- Tab links -->
						<div style="margin-top: -20px" class="tab">
						  <button class="tablinks" onclick="openList(event, 'Watch')" id="defaultOpen">全集列表</button>
						  <button class="tablinks" onclick="openList(event, 'Related')">相關影片</button>
						</div>

						<!-- Tab content -->
						<div id="Watch" class="tabcontent">
							<div style="padding: 7px 15px;">
								<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- Horizontal Banner Ads -->
								<ins class="adsbygoogle"
								     style="display:block;"
								     data-ad-client="ca-pub-4485968980278243"
								     data-ad-slot="8455082664"
								     data-ad-format="auto"
								     data-full-width-responsive="true"></ins>
								<script>
								     (adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							</div>

							<div class="dropdown">
							  <button onclick="openDropdown()" class="dropbtn">{{ $watch->season }}<span style="padding-left: 7px; padding-right: 0px;" class="stretch dropbtn">v</span></button>
							  <div id="myDropdown" class="dropdown-content">
							      @foreach ($dropdown as $watch)
							      	<a style="color:white; text-decoration: none;" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">{{ $watch->season }}</a>
							      @endforeach
							  </div>
							</div>

						    @foreach ($videos as $video)
							    <div style="{{ $video->id == $current->id ? 'background-color: #7A7A7A' : '' }}">
							    	@include('video.singleRelatedWatch')
						    	</div>
						    @endforeach
						</div>

						<div id="Related" class="tabcontent">
							@foreach ($related as $video)
						    	@include('video.singleRelatedPost')
						    @endforeach
						</div>
					</div>
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

			/* When the user clicks on the button,
			toggle between hiding and showing the dropdown content */
			function openDropdown() {
			  document.getElementById("myDropdown").classList.toggle("show");
			}

			// Close the dropdown menu if the user clicks outside of it
			window.onclick = function(event) {
			  if (!event.target.matches('.dropbtn')) {
			    var dropdowns = document.getElementsByClassName("dropdown-content");
			    var i;
			    for (i = 0; i < dropdowns.length; i++) {
			      var openDropdown = dropdowns[i];
			      if (openDropdown.classList.contains('show')) {
			        openDropdown.classList.remove('show');
			      }
			    }
			  }
			}
		</script>
	</div>
@endsection
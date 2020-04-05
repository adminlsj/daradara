@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'dark'])
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
						<div style="position: relative;" class="tab" id="video-show-tabs-margin-top">
							<button style="{{ $is_program ? '' : 'display:none' }}" class="tablinks video-tablinks" onclick="openList(event, 'Watch')" id={{ $is_program ? 'defaultOpen' : '' }}>全集列表</button>
							<button class="tablinks video-tablinks" onclick="openList(event, 'Related')" id={{ $is_program ? '' : 'defaultOpen' }}>相關影片</button>
							@if ($is_program)
								<a style="position:absolute; top:14px; right:53px; text-decoration: none; {{ $prev != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $prev }}"><i class="material-icons noselect">skip_previous</i></a>
								<a style="position:absolute; top:14px; right:13px; text-decoration: none; margin-left: 8px; {{ $next != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $next }}"><i class="material-icons noselect">skip_next</i></a>
							@endif
						</div>

						<!-- Tab content -->
						@if ($is_program)
							<div id="Watch" class="tabcontent" style="padding-bottom: 7px;">
								<div class="dropdown" style="margin-top: -5px">
								  <button onclick="openDropdown()" class="dropbtn">{{ $watch->season }}<span style="padding-left: 7px; padding-right: 0px;" class="stretch dropbtn">v</span></button>
								  <div id="myDropdown" class="dropdown-content">
								      @foreach ($dropdown as $watch)
								      	<a style="color:white; text-decoration: none;" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">{{ $watch->season }}</a>
								      @endforeach
								  </div>
								</div>

								<div class="hidden-xs hidden-sm" style="margin: 7px 15px 0px 15px;">
									<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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

								<div id="video-playlist-wrapper">
									<div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 14px; padding-bottom: 28px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
								</div>
							</div>
						@endif

						<div id="Related" class="tabcontent" style="padding-bottom: 7px;">
							@if (!$is_program)
								<div class="hidden-xs hidden-sm" style="margin: 7px 15px 7px 15px;">
									<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
							@endif
							@foreach ($related as $video)
						    	@include('video.singleRelatedPost')
						    @endforeach
						</div>

						@if ($is_mobile)
							<div style="border-top: solid 1px #383838;">
								@include('video.comment-section-wrapper')
							</div>
						@endif
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
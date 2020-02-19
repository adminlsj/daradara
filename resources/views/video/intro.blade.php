@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $watch->title }} | {{ $watch->genre() }}線上看 | 中文字幕 | 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $watch->title }} | {{ $watch->genre() }}線上看 | 中文字幕 | 娛見日本 LaughSeeJapan">
    <meta name="description" content="{{ $watch->description }}">
@endsection

@section('nav')
  @include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/xSMGFWh.png', 'backgroundColor' => '#282828', 'itemsColor' => 'white', 'menuBtnColor' => 'white'])
@endsection

@section('content')
    <div class="hidden-sm hidden-xs sidebar-menu">
	    @include('video.sidebarMenu', ['theme' => 'dark'])
    </div>

    <div class="main-content">
    	<div style="background-color: #1F1F1F;">
			<div style="background-image: url({{ $watch->imgurH() }}); background-size: 100%; background-repeat: no-repeat; background-position: 50%; filter: blur(30px); z-index: -1; opacity: 0.5; pointer-events: none;">
				<div style="padding: 0px 15px">
					<div style="padding-top: 20px; padding-bottom: 10px; padding-left: 0px;" class="row">
						@include('video.introTemp')
					</div>
				</div>
			</div>
			<div style="padding: 0px 15px;">
				<div class="row" style="padding-top: 62px; padding-bottom: 10px; padding-left: 0px; margin-right:0px; position: absolute; top: 0px;">
					@include('video.introTemp')
				</div>
			</div>

			<hr style="border:solid 1.5px #282828; margin-top: 0px">

			<div style="margin-top: -20px; padding: 0px 15px">
				<div class="row">
					<!-- Tab links -->
					<div class="tab">
					  <button class="tablinks" onclick="openList(event, 'Watch')" id="defaultOpen">全集列表</button>
					  <button class="tablinks" onclick="openList(event, 'Related')">相關影片</button>
					</div>

					<!-- Tab content -->
					<div id="Watch" class="tabcontent">
						<div class="dropdown">
						  <button onclick="openDropdown()" class="dropbtn">{{ $watch->season }}<span style="padding-top: 0px; padding-left: 7px; padding-right: 0px;" class="stretch dropbtn">v</span></button>
						  <div id="myDropdown" class="dropdown-content">
						      @foreach ($dropdown as $watch)
						      	<a style="color:white; text-decoration: none;" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">{{ $watch->season }}</a>
						      @endforeach
						  </div>
						</div>

					    @foreach ($videos as $video)
						    <div id="{{ $video->id }}" style="padding: 7px 4px;">
							  <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="row no-gutter">
							    <div style="padding-left: 12px; padding-right: 4px; position: relative;" class="col-xs-6 col-sm-6 col-md-3">
							      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
							      <img style="opacity: 0.6;" class="play-button-cover" src="https://i.imgur.com/WSrfkoQ.png" alt="play button">
							      <img class="play-button-cover" src="https://i.imgur.com/BrOdkqU.png" alt="play button">
							      <span style="position: absolute; bottom:6px; right: 9px; background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px;">{{ $video->duration() }}</span>
							    </div>
							    <div style="padding-top: 1px; padding-right: 12px; padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-9">
							      <h4 style="margin-top:0px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em; color:white;">{{ $video->title() }}</h4>
							      <p style="color: gray; margin-top: 1px; margin-bottom: 0px; font-size: 0.85em; color:#e5e5e5">觀看次數：{{ $video->views() }}次</p>
							      <div class="hidden-sm hidden-xs" style="margin-top:5px; font-size: 0.95em; color: #cccccc; line-height: 19px; white-space: pre-wrap;">{{ $video->caption }}</div>
							    </div>
							</div>

					    	<a class="visible-sm visible-xs" style="text-decoration: none; padding: 0px 7px;" href="{{ route('video.watch') }}?v={{ $video->id }}">
						    	<div class="padding-setup" style="font-size: 0.95em; color: #cccccc; line-height: 19px; white-space: pre-wrap;">{{ $video->caption }}</div>
						    </a>
					    	<br>
					    @endforeach
					</div>

					<div id="Related" style="padding: 7px 8px;" class="tabcontent">
				  		@foreach ($related as $watch)
				  			<div class="{{ $watch->genre == 'variety' ? 'watch-variety' : 'watch-single' }}">
					            <div style="background-color: #282828; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
					              <a style="text-decoration: none;" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">

					                <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-top-right-radius: 3px; padding-top: 1px; padding-left: 1px; padding-right: 1px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">

					                <div style="height: 47px; padding: 0px 8px;">
					                  <div style="margin-top: -29px;float: right; margin-right: -3px">
					                    <span style="background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px; font-weight: 300">
					                      @if ($watch->genre == 'variety')
					                        {{ Carbon\Carbon::parse($watch->updated_at)->diffForHumans() }}更新
					                      @else
					                        {{ $watch->is_ended ? '已完結全' : '更新至第' }}{{ $watch->videos()->count() }}集
					                      @endif
					                    </span>
					                  </div>
					                  <h4 style="color:white; margin-top:6px; line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: {{ $watch->genre == 'variety' ? 1 : 2 }}; -webkit-box-orient: vertical; font-weight: 500;">{{ $watch->title }}</h4>

					                  <p style=" color: #a9a9a9; margin-top: -6px; margin-bottom: 2px; font-size: 0.8em; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; {{ $watch->genre == 'variety' ? '' : 'display:none;' }}">
					                    {{ $watch->cast }}
					                  </p>
					                </div>
					              </a>
					            </div>
					        </div>
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
	</div>
@endsection
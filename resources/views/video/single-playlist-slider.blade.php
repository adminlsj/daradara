<div class="slider-wrapper" style="position: relative;">
	<div id="custom-scroll-slider">
	    @foreach ($playlists as $watch)
	        <div class="hover-opacity single-playlist-slider" style="display: inline-block; vertical-align: text-top; position: relative;">
			    <a style="text-decoration: none; color: black" href="{{ route('video.playlist') }}?list={{ $watch->id }}">
			      <img class="lazy" style="width: 100%; height: 100%;" src="https://i.imgur.com/JMcgEkPl.jpg" data-src="{{ $watch->videos()->first() ? $watch->videos()->first()->imgurH() : 'https://i.imgur.com/JMcgEkPl.jpg' }}" data-srcset="{{ $watch->videos()->first() ? $watch->videos()->first()->imgurH() : 'https://i.imgur.com/JMcgEkPl.jpg' }}" alt="{{ $watch->title }}">
			      <span>
			          <div>{{ $watch->videos()->count() }}</div>
			          <i style="font-size: 1.6em; margin-right: -5px" class="material-icons">playlist_play</i>
			      </span>

			      <div class="hover-underline">
			        <h4 style="padding-right: 10px" class="text-ellipsis">{{ $watch->title }}</h4>
			      </div>
			    </a>
			</div>
	    @endforeach
	</div>
	<div class="slider-scroll-left no-select"><i style="vertical-align:middle; font-size: 1em; margin-top: -7px; margin-left: 3px" class="material-icons">arrow_back_ios</i></div>
	<div class="slider-scroll-right no-select" style="{{ $is_mobile ? 'display:none' : '' }}"><i style="vertical-align:middle; font-size: 1em; margin-top: -7px; margin-left: 1px;" class="material-icons">arrow_forward_ios</i></div>
</div>
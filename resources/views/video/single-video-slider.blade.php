<div class="slider-wrapper" style="position: relative;">
	<div id="custom-scroll-slider">
	    @foreach ($videos as $video)
	        <div class="hover-opacity" style="display: inline-block; vertical-align: text-top;">
			    <a style="text-decoration: none; color: black" class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}">
				    <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">

				    <div class="hover-underline">
					    <h4 class="text-ellipsis">@if ($video->category != 'video'){{ $video->watch()->title }}@endif {{ $video->explodeTitle() }}</h4>
				    </div>
			    </a>
			</div>
	    @endforeach
	</div>
	<div class="slider-scroll-left no-select"><i style="vertical-align:middle; font-size: 1em; margin-top: -7px; margin-left: 3px" class="material-icons">arrow_back_ios</i></div>
	<div class="slider-scroll-right no-select"><i style="vertical-align:middle; font-size: 1em; margin-top: -7px; margin-left: 1px; {{ $is_mobile ? 'display:none' : '' }}" class="material-icons">arrow_forward_ios</i></div>
</div>
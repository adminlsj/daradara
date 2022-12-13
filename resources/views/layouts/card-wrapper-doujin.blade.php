<a style="text-decoration: none;" href="/">
	<h3>{{ $title }}</h3>
</a>
<div style="position: relative;">
	@include('layouts.card-navigate-before')
	<div class="home-rows-videos-wrapper no-scrollbar-style" style="margin-left: 0px; margin-right: -3px;">
		@foreach ($videos as $video)
			<div class="multiple-link-wrapper search-doujin-videos home-doujin-videos hidden-xs" style="display: inline-block; padding-right: 3px;">
				<a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
				@include('video.card-doujin-desktop')
			</div>
			<div class="multiple-link-wrapper search-doujin-videos home-doujin-videos hidden-sm hidden-md hidden-lg hidden-xl" style="display: inline-block; padding-right: 3px;">
				<a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
				@include('layouts.card-doujin-mobile')
			</div>
		@endforeach
	</div>
	@include('layouts.card-navigate-after')
</div>
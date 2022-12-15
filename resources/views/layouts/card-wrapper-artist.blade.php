<a style="text-decoration: none;" href="{{ $link }}">
	<h3>{{ $title }}</h3>
</a>
<div style="position: relative;">
	@include('layouts.card-navigate-before')
	<div class="home-rows-videos-wrapper no-scrollbar-style" style="margin-left: 0px; margin-right: -3px;">
		@foreach ($artists as $artist)
			<div class="multiple-link-wrapper search-doujin-videos home-doujin-videos home-artist-card" style="display: inline-block; padding-right: 3px;">
				<a class="overlay" href="{{ route('home.search') }}?query={{ $artist->name }}"></a>
				@include('video.card-artist-desktop')
			</div>
		@endforeach
	</div>
	@include('layouts.card-navigate-after')
</div>
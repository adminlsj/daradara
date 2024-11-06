<a style="text-decoration: none;" href="{{ $link }}">
	<h3 style="font-weight: 400; color: #e5e5e5;">{{ $title }}</h3>
</a>
<div style="position: relative;">
	@include('layouts.card-navigate-before')
	<div class="home-rows-videos-wrapper no-scrollbar-style" style="margin-left: -3px; margin-right: -3px;">
		@foreach ($videos as $video)
			@include('layouts.card-desktop')
		@endforeach
	</div>
	@include('layouts.card-navigate-after')
</div>
<a style="text-decoration: none;" href="{{ $link }}">
	<h3>{{ $title }}</h3>
</a>
<div style="position: relative;">
	@include('layouts.card-navigate-before')
	<div class="home-rows-videos-wrapper no-scrollbar-style" style="margin-left: -3px; margin-right: -3px;">
		@foreach ($videos as $item)
			@if ($item->video)
				@include('layouts.card-desktop', ['video' => $item->video])
			@endif
		@endforeach
	</div>
	@include('layouts.card-navigate-after')
</div>
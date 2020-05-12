@if ($videos)
	@foreach ($videos as $video)
	    <div class="related-watch-wrap" style="{{ $video->id == $current->id ? 'background-color: #E5E5E5' : '' }};">
	    	@include('video.singleShowRelated', ['source' => 'playlist'])
		</div>
	@endforeach
	<hr style="margin: 7px 15px; border-color: #e5e5e5">
@endif

@foreach ($related as $video)
    <div class="related-watch-wrap hover-opacity-all" style="position: relative;">
    	@include('video.singleShowRelated', ['source' => 'video'])
	</div>
@endforeach
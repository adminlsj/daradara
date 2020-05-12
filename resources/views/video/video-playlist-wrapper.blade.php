@if ($videos)
	@foreach ($videos as $video)
	    <div class="related-watch-wrap hover-opacity-all" style="{{ $video->id == $current->id ? 'background-color: #E5E5E5' : '' }};">
	    	@include('video.singleShowRelated', ['source' => 'playlist'])
		</div>
	@endforeach
	<hr style="margin: 15px; border-color: #e5e5e5">
@endif

@foreach ($related as $video)
    <div class="related-watch-wrap hover-opacity-all">
    	@include('video.singleShowRelated', ['source' => 'video'])
	</div>
@endforeach
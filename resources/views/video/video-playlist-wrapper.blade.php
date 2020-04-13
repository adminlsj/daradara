@foreach ($videos as $video)
    <div class="related-watch-wrap" style="{{ $video->id == $current->id ? 'background-color: #E5E5E5' : '' }};">
    	@include('video.singleRelatedWatch')
	</div>
@endforeach
@foreach ($videos as $video)
    <div class="related-watch-wrap" style="{{ $video->id == $current->id ? 'background-color: #7A7A7A' : '' }};">
    	@include('video.singleRelatedWatch')
	</div>
@endforeach
<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
	<div class="home-rows-videos-div" style="position: relative; display: inline-block;">
		<img style="border-radius: 3px" src="{{ $video->cover }}">
		@if (strpos($video->cover, 'E6mSQA2') !== false)
          <img style="position: absolute; top: 0; left: 0; height: 100%; object-fit: cover; padding-left: 2px; padding-right: 2px" src="{{ $video->thumbL() }}">
        @endif
        <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ str_replace('[新番預告]', '', $video->title) }}</div>
    </div>
</a>
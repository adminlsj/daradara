<a style="text-decoration: none;" href="{{ $link }}">
	<h3>{{ $title }}<span style="vertical-align: middle; margin-top: -2px; margin-left: 2px" class="material-icons">chevron_right</span></h3>
</a>
<div style="position: relative;">
	<div class="hidden-xs hidden-sm no-select navigate-before-btn" style="background-color: rgba(0, 0, 0, .7); height: 100%; width: 4%; position: absolute; top: 0; left: 0; cursor: pointer; z-index: 1; display: none;">
		<span class="material-icons" style="font-size: 50px; color: white; margin: 0; position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">navigate_before</span>
	</div>
	<div class="home-rows-videos-wrapper no-scrollbar-style" style="margin-left: -2px; margin-right: -2px;">
		@foreach ($data['videos'] as $video)
			<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
				<div class="home-rows-videos-div" style="position: relative; display: inline-block;">
					<img src="{{ $video->cover }}">
					@if (strpos($video->cover, 'E6mSQA2') !== false)
	                  <img style="position: absolute; top: 0; left: 0; height: 100%; object-fit: cover; padding-left: 2px; padding-right: 2px" src="{{ $video->thumbL() }}">
	                @endif
			        <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video->title }}</div>
		        </div>
			</a>
		@endforeach
	</div>
	<div class="hidden-xs hidden-sm no-select navigate-next-btn" style="background-color: rgba(0, 0, 0, .7); height: 100%; width: 4%; position: absolute; top: 0; right: 0; cursor: pointer; z-index: 1">
		<span class="material-icons" style="font-size: 50px; color: white; margin: 0; position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">navigate_next</span>
	</div>
</div>
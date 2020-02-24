<div style="margin-bottom: 30px;">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;">
		<img style="width: 100%;" src="{{ $video->imgurH() }}" alt="{{ $video->title }}">
	</a>

	<div class="padding-setup" style="margin-top: 10px">
		<a href="{{ route('video.intro', [$video->genre, $video->watch()->titleToUrl()]) }}" style="text-decoration: none;">
			<img style="width: 45px; height: auto; float: left; border-radius: 50%;" src="https://i.imgur.com/{{ $video->watch()->imgur }}s.jpg" alt="{{ $video->watch()->title }}">
		</a>
		<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; color: black;">
			<div style="margin-left: 53px; font-size: 1.1em; line-height: 19px">{{ $video->title }}</div>
			<div style="margin-left: 53px; font-size: 0.85em; color: dimgray; margin-top: 3px;">{{ $video->watch()->title }} • 收看次數：{{ $video->views() }} • {{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</div>
		</a>
	</div>
</div>
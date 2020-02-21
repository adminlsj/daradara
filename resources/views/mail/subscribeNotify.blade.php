@component('mail::message')

<div>
	<a href="/"><img src="https://i.imgur.com/M8tqx5K.png" height="30" alt="娛見日本 LaughSeeJapan"></a>
</div>

<div style="margin-top: 15px">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;">
		<img src="https://i.imgur.com/{{ $video->imgur }}.png" alt="{{ $video->title }}">
	</a>
</div>

<div style="margin-top: 3px;">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; color: black;">
		<img style="width: 30px; height: auto; float: left; border-radius: 50%;" src="https://i.imgur.com/{{ $video->watch()->imgur }}s.jpg" alt="{{ $video->watch()->title }}">
		<div style="margin-left: 38px; font-size: 0.95em;">{{ $video->title }}</div>
		<div style="margin-left: 38px; font-size: 0.7em; color: gray">{{ $video->watch()->title }}</div>
	</a>
</div>

<hr style="color: darkgray; border-width: 0.5px; margin: 15px 0px;">

<div style="font-size: 0.7em; color: gray">
	您收到這封電子郵件是因為您選擇接收來自《{{ $video->watch()->title }}》的更新。如果不想再收到這些更新，可以<a href="{{ route('video.watch') }}?v={{ $video->id }}">在這裡取消訂閱</a>。
</div>

<div style="font-size: 0.7em; color: gray; margin-top: 15px">
	© 2020 娛見日本 LaughSeeJapan
</div>

@endcomponent
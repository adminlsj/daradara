@component('mail::message')

<div>
	<a href="/"><img src="https://i.imgur.com/DWGvZ7Y.png" height="30"></a>
</div>

<div style="margin-top: 15px">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}&utm_source=email" style="text-decoration: none;">
		<img src="https://i.imgur.com/{{ $video->imgur }}h.png">
	</a>
</div>

<div style="margin-top: 3px;">
	<a href="{{ route('user.show', $video->user()) }}" style="text-decoration: none; color: black;">
		<img style="width: 30px; height: auto; float: left; border-radius: 50%;" src="{{ $video->user()->avatar == null ? $video->user()->avatarDefault() : $video->user()->avatar->filename }}" alt="{{ $video->title }}">
	</a>
	<a href="{{ route('video.watch') }}?v={{ $video->id }}&utm_source=email" style="text-decoration: none; color: black;">
		<div style="margin-left: 38px; font-size: 16px;">{{ $video->title }}</div>
		<div style="margin-left: 38px; font-size: 12px; color: gray">{{ $video->user()->name }}</div>
		<div style="margin-left: 38px; font-size: 12px; color: gray; margin-top: 5px">{{ $video->caption }}</div>
	</a>
</div>

<hr style="color: darkgray; border-width: 0.5px; margin: 15px 0px;">

<div style="font-size: 10px; color: gray">
	您收到這封電子郵件是因為您選擇接收來自《{{ $title }}》的更新。如果不想再收到這些更新，可以<a href="{{ route('video.watch') }}?v={{ $video->id }}&utm_source=email">在這裡取消訂閱</a>。
</div>

<div style="font-size: 10px; color: gray; margin-top: 15px">
	© 2020 娛見日本 LaughSeeJapan
</div>

@endcomponent
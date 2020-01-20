@component('mail::message')
以下為用戶回報無法觀看的影片詳情：

<br>

<div><span style="font-weight: 600">id: </span>{{ $video->id }}</div>
<div><span style="font-weight: 600">title: </span>{{ $video->title }}</div>
<div><span style="font-weight: 600">reason: </span>{{ $reason }}</div>
<div><span style="font-weight: 600">time: </span>{{ Carbon\Carbon::now()->addHours(8)->format('Y-m-d H:i:s') }}</div>
<div><span style="font-weight: 600">link: </span>{{ route('video.watch') }}?v={{ $video->id }}</div>
<div><span style="font-weight: 600">sd: </span>{{ $video->sd }}</div>

@component('mail::button', ['url' => '{{ route("video.watch") }}?v={{ $video->id }}'])
<span style="font-size: 15px">LaughSeeJapan</span>
@endcomponent

Thanks for using LaughSeeJapan,<br>
{{ config('app.name') }}
@endcomponent
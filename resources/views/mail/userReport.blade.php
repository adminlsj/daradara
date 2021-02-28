@component('mail::message')
以下為用戶回報無法觀看的影片詳情：

<br>

<div><span style="font-weight: 600">id: </span>{{ $video_id }}</div>
<div><span style="font-weight: 600">title: </span>{{ $video_title }}</div>
<div><span style="font-weight: 600">reason: </span>{{ $reason }}</div>
<div><span style="font-weight: 600">country code: </span>{{ $country_code }}</div>
<div><span style="font-weight: 600">ip address: </span>{{ $ip_address }}</div>
<div><span style="font-weight: 600">email: </span>{{ $email }}</div>
<div><span style="font-weight: 600">time: </span>{{ Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</div>
<div><span style="font-weight: 600">link: </span>{{ route('video.watch') }}?v={{ $video_id }}</div>
<div><span style="font-weight: 600">sd: </span>{{ $video_sd }}</div>

@component('mail::button', ['url' => '{{ route("video.watch") }}?v={{ $video->id }}'])
<span style="font-size: 15px">LaughSeeJapan</span>
@endcomponent

Thanks for using LaughSeeJapan,<br>
{{ config('app.name') }}
@endcomponent
@component('mail::message')
以下為用戶上傳的影片詳情：

<br>

<div><span style="font-weight: 600">user: </span>[{{ $user->id }}] {{ $user->name }}</div>
<div><span style="font-weight: 600">genre: </span>{{ $genre }}</div>
<div><span style="font-weight: 600">category: </span>{{ $category }}</div>
<div><span style="font-weight: 600">watchDescription: </span>{{ $watchDescription }}</div>
<div><span style="font-weight: 600">title: </span>{{ $title }}</div>
<div><span style="font-weight: 600">videoDescription: </span>{{ $videoDescription }}</div>
<div><span style="font-weight: 600">image: </span>{{ $image }}</div>
<div><span style="font-weight: 600">link: </span>{{ $link }}</div>

<br>

Thanks for using LaughSeeJapan,<br>
{{ config('app.name') }}
@endcomponent
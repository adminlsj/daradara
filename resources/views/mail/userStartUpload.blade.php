@component('mail::message')
以下為開始上傳的用戶詳情：

<br>

<div><span style="font-weight: 600">id: </span>{{ $user->id }}</div>
<div><span style="font-weight: 600">name: </span>{{ $user->name }}</div>
<div><span style="font-weight: 600">email: </span>{{ $user->email }}</div>

<br>

@endcomponent
@component('mail::message')
Dear {{ $user_email }},

<br>

Thank you for reaching us. Your query has been received, and we will be in contact with you shortly! The contact details are received as follow:

<br>

<div><span style="font-weight: 600">Email: </span>{{ $user_email }}</div>
<div><span style="font-weight: 600">Title: </span>{{ $title }}</div>
<div><span style="font-weight: 600">Content: </span>{{ $text }}</div>

@component('mail::button', ['url' => '/'])
<span style="font-size: 15px">FreeRider</span>
@endcomponent

Thanks for using FreeRider,<br>
{{ config('app.name') }}
@endcomponent
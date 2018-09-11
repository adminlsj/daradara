@component('mail::message')
Dear {{ $user->name }},

Your application for the position <span style="font-weight: 600">{{ $job->title }} </span> was sent to <span style="font-weight: 600">{{ $job->company->name }}</span>. You may check the progress of your application through the link below.

@component('mail::button', ['url' => route('app.index')])
<span style="font-size: 15px">My Applications</span>
@endcomponent

Thanks for using TwoBayJobs,<br>
{{ config('app.name') }}
@endcomponent
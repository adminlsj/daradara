@component('mail::message')
Dear {{ $user->name }},

You application for <span style="font-weight: 600">{{ $job->title }}</span> was sent to <span style="font-weight: 600">{{ $job->company->name }}</span>. Here's a copy for your reference.

...RESUME OVERVIEW...

@component('mail::button', ['url' => route('app.index')])
My Applications
@endcomponent

Thanks for using TwoBayJobs,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
New Application by User #{{ $user->id }} for Job #{{ $job->id }}

New Application by User [{{ $user->name }}] for Job [{{ $job->title }}]

Attached with Resume #{{ $user->resume->id }} and File [{{ $haveResumeImg ? $resume->resumeImg->original_filename : 'None' }}]

NOW, Send the Resume and File to the Company of the Job either by the source website or direct mail.

ALSO, remember to change the status of the application.

GOGOGO,<br>
{{ config('app.name') }}
@endcomponent

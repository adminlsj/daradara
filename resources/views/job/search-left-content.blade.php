<div style="position: relative;" class="hidden-xs hidden-sm row selectJobContainer">
    <form id="selectJob{{ $job->id }}" action="{{route('job.select', ['job' => $job->id])}}" method="POST">
        {{ csrf_field() }}
        <button id="selectJobBtn{{ $job->id }}" type="submit" style="cursor:pointer; width:100%; padding:15px 30px; text-align:left; border:none; border-bottom: 1px solid #E6E6E6; {{ $currentJob->id == $job->id ? 'background-color:#d84b6b; color:white':'' }}">
            <div><a id="selectJobTitle{{ $job->id }}" style="{{ $currentJob->id == $job->id ? 'color:white;':'color:#d84b6b;' }}font-size: 18px;" href="{{ route('job.show', ['job' => $job->id]) }}" target="_blank">{{ str_limit($job->title, 32) }}</a></div>
            <div> {{ $job->company->name }}</div>
            <div> {{ $job->location }}<span style="font-size: 12px; font-weight:300; font-family: sans-serif;" class="pull-right">{{ $job->experience == 0 ? '無需經驗' : $job->experience.'年經驗' }}</span></div>
            <div> {{ $job->created_at->diffForHumans() }}<span style="font-weight: 600" class="pull-right">{{ $job->salary == 1 ? '薪資面議' : 'RMB ¥'.$job->salary.' / 月' }}</span></div>
            <input type="hidden" id="currentId" name="currentId" value="{{$currentJob->id}}">
        </button>
    </form>
    @include('job.save-job-form-left')
</div>

<div style="position: relative;" class="visible-xs-block visible-sm-block row selectJobContainer">
    <form action="{{route('job.show', ['job' => $job->id])}}">
        <button class="mobileSelectJobBtn" type="submit" style="cursor:pointer; width:100%; padding:15px 30px; text-align:left; border:none; border-bottom: 1px solid #E6E6E6;">
            <div><a style="color:#d84b6b;font-size: 18px;" href="{{ route('job.show', ['job' => $job->id]) }}" target="_blank">{{ str_limit($job->title, 32) }}</a></div>
            <div> {{ $job->company->name }}</div>
            <div> {{ $job->location }}<span style="font-size: 12px; font-weight:300; font-family: sans-serif;" class="pull-right">{{ $job->experience == 0 ? '無需經驗' : $job->experience.'年經驗' }}</span></div>
            <div> {{ $job->created_at->diffForHumans() }}<span style="font-weight: 600" class="pull-right">{{ $job->salary == 1 ? '面議' : 'RMB ¥'.$job->salary.' / 月' }}</span></div>
        </button>
    </form>
    @include('job.save-job-form-left-mobile')
</div>
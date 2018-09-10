@foreach($relatedJobs as $job)
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-5 col-sm-3 col-xs-5">
            <a href="{{ route('job.show', ['job' => $job->id]) }}" target="_blank">
                    <img style="border: solid 1px #f2f2f2" src="https://s3-us-west-2.amazonaws.com/freerider/avatars/originals/default_freerider_profile_pic.jpg" class="img-responsive img-circle">
            </a>
        </div>
        <div class="col-md-7 col-sm-9 col-xs-7">
            <div><a href="{{ route('job.show', ['job' => $job->id]) }}" target="_blank"><h3 style="color: black; font-weight: 400; font-size: 15px">{{ str_limit($job->title, 50) }}</h3></a></div>
            <div style="font-size: 12.5px;"><span style="font-weight: 600;">${{ $job->salary }}</span> + $0 限時免運費</div>
            <div class="hidden-xs" style="font-size: 12.5px">{{ $job->created_at->toDateString() }} 前</div>
        </div>
    </div>
@endforeach


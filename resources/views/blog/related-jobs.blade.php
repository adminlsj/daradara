@foreach($relatedJobs as $job)
    <div class="hidden-xs hidden-sm">
        <a href="/jobs/search?title={{ $job->title }}" target="_blank">
            <div class="row hover-box-shadow" style="border-radius: 3px; border: solid 1px #f2f2f2; margin-bottom: 15px; background-color:white; padding: 15px 10px">
                <div class="col-md-12">
                    <div style="color:#d84b6b; font-size: 18px;" href="{{ route('job.show', ['job' => $job->id]) }}" target="_blank">{{ str_limit($job->title, 60) }}</div>
                    <div style="color: #42464A"> {{ $job->company->name }}</div>
                    <div style="color: #42464A"> {{ $job->location }} </div>
                    <div style="color: #42464A"> {{ $job->created_at->diffForHumans() }}<span style="font-weight: 600" class="pull-right">${{ $job->salary }} / 月</span></div>
                </div>
            </div>
        </a>
    </div>

    <div class="visible-xs-block visible-sm-block">
        <a href="{{ route('job.show', ['job' => $job->id]) }}" target="_blank">
            <div class="row hover-box-shadow" style="border-radius: 3px; border: solid 1px #f2f2f2; margin-bottom: 15px; background-color:white; padding: 15px 10px">
                <div class="col-md-12">
                    <div style="color:#d84b6b; font-size: 18px;">{{ str_limit($job->title, 60) }}</div>
                    <div style="color: #42464A"> {{ $job->company->name }}</div>
                    <div style="color: #42464A"> {{ $job->location }} </div>
                    <div style="color: #42464A"> {{ $job->created_at->diffForHumans() }}<span style="font-weight: 600" class="pull-right">${{ $job->salary }} / 月</span></div>
                </div>
            </div>
        </a>
    </div>
@endforeach


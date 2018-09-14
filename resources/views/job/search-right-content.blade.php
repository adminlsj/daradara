<div id="showJob" class="container card-shadow">
    @if ($currentJob != null)
        <div style="font-size: 25px" id="job-company-name"> {{ $currentJob->company->name }} </div>
        <div style="font-size: 15px" id="job-company-description"> {{ $currentJob->company->description }} </div>
        <hr style="margin-bottom: 12px">
        <div style="font-weight: 600; text-align: center">
            <span style="margin-top: -2px" class="pull-left"><i style="vertical-align: bottom" class="material-icons">place</i> <span id="job-location">{{ $currentJob->location }}</span></span>
            <span id="showJobSalary"><span id="job-salary">{{ $currentJob->salary == 1 ? '薪資面議' : 'RMB ¥'.$currentJob->salary.' / 月'}}</span></span>
            <span class="pull-right">
            </span>
        </div>
        <hr style="margin-top: 12px">
        <div style="font-size: 25px; text-align: center" id="job-title"> {{ $currentJob->title }} </div>
        <hr>
        <div style="font-size: 15px; font-weight: 600">Responsibilities:</div>
        <pre id="job-responsibility">{{ $currentJob->responsibility }}</pre>
        <br>
        <div style="font-size: 15px; font-weight: 600">Requirements:</div>
        <pre id="job-requirement">{{ $currentJob->requirement }}</pre>
        <br>
        <div style="font-size: 15px; font-weight: 600">All Personal data collected will be used for recruitment purpose only. </div>
        <br>

        <div class="row sidenav" style="margin-top: 5px">
            <div class="col-xs-6 col-xs-offset-3 col-md-4 col-md-offset-4">
                <form action="{{ route('app.create') }}" method="GET">
                    <input type="hidden" name="job_id" id="job_id" value="{{ $currentJob->id }}">
                    <button id="applyBtn" {{ $disabled }} type="submit" target="_blank" class="btn btn-info btn-block">
                        {{ $btn_text }}
                    </button>
                </form>
            </div>
        </div>
    @else
        <div style="font-size: 20px; line-height: 40px;">
            <h2>No jobs matching your keyword: <span style="font-weight: 600">{{ request('title') }}</span></h2>
            <br>
            <div style="font-weight: 600">Suggestions:</div>
            <div>- Make sure all words are spelled correctly</div>
            <div>- Try more general keywords</div>
            <div>- Try different keywords</div>
        </div>
        <br><br><br><br><br><br>
    @endif
</div>
@if (auth()->check())
    <div style="display:{{ App\SavedJob::where('user_id', auth()->user()->id)->where('job_id', $job->id)->count() == 0 ? 'none':'initial' }}">
        <button style="position:absolute; top:17px; right:20px; cursor:pointer; background-color:transparent; padding: 0px; border:0px" type="submit"><i style="color:#f8d23a" class="material-icons saveJobIcon">favorite</i></button>
    </div>
@endif
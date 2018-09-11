@if (auth()->check())
    <form id="saveJob{{ $job->id }}" style="display:{{ $currentJob->id != $job->id && App\SavedJob::where('user_id', auth()->user()->id)->where('job_id', $job->id)->count() == 0 ? 'none':'initial' }}" action="{{route('job.save', ['job' => $job->id])}}" method="POST">
        {{ csrf_field() }}
        <button style="position:absolute; top:17px; right:20px; cursor:pointer; background-color:transparent; padding: 0px; border:0px" type="submit"><i id="saveJobIcon{{ $job->id }}" style="color:{{ App\SavedJob::where('user_id', auth()->user()->id)->where('job_id', $job->id)->count() != 0 ? '#f8d23a':'white' }};" class="material-icons saveJobIcon">favorite</i></button>
    </form>
@else
    <form id="redirectToRegister{{ $job->id }}" style="display:{{ $currentJob->id != $job->id ? 'none':'initial' }}" action="{{ route('register') }}">
        <button style="position:absolute; top:17px; right:20px; cursor:pointer; background-color:transparent; padding: 0px; border:0px" type="submit"><i style="color:white;" class="material-icons saveJobIcon">favorite</i></button>
    </form>
@endif
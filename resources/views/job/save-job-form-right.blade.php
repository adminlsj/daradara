@if (auth()->check())
    <form id="saveJob{{ $currentJob->id }}" action="{{route('job.save', ['job' => $currentJob->id])}}" method="POST">
        {{ csrf_field() }}
        <button style="cursor:pointer; background-color:transparent; padding: 0px; border:0px" type="submit"><i id="saveJobIcon{{ $currentJob->id }}" style="color:{{ App\SavedJob::where('user_id', auth()->user()->id)->where('job_id', $currentJob->id)->count() != 0 ? '#f8d23a':'#42464A' }};" class="material-icons saveJobIcon">favorite_border</i></button>

        <input type="hidden" id="currentId" name="currentId" value="{{$currentJob->id}}">
    </form>
@else
    <form id="redirectToRegister{{ $currentJob->id }}" action="{{ route('register') }}">
        <button style="position:absolute; top:17px; right:20px; cursor:pointer; background-color:transparent; padding: 0px; border:0px" type="submit"><i style="color:white;" class="material-icons saveJobIcon">favorite</i></button>
    </form>
@endif
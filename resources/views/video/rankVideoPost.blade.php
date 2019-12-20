<a href="{{ route('video.watch') }}?v={{ $video->id }}">
    <div class="row">
        <div class="col-xs-5 col-sm-5 col-md-5">
            <img style="border-radius: 5px; width: 100%; height: 100%;" src="https://i.imgur.com/{{ $video->imgur }}m.png" alt="{{ $video->title }}">
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5" style="padding-left: 0px; padding-right: 0px;">
            <h4 style="margin-top: 0px; font-weight: 500; line-height: 19px; font-size: 1em; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $video->title }}</h4>
            <p style="color: #a9a9a9; margin-top: -8px; margin-bottom: 0px; font-size: 0.8em;">
                <i style="vertical-align:middle; font-size: 1.15em; margin-top: -2.5px;" class="material-icons">remove_red_eye</i>
                {{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}
            </p>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2" style="text-align: right">
            <h5 style="margin-top: 8px;">no.</h5>
        </div>
    </div>
</a>
<hr style="margin: 15px 0px;">
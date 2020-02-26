<a id="singleRankVideo" href="{{ route('video.watch') }}?v={{ $video->id }}">
    <div class="row">
        <div class="col-xs-5 col-sm-5 col-md-4 col-lg-3">
            <img class="lazy" style="border-radius: 5px; width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
        </div>
        <div class="col-xs-5 col-sm-5 col-md-6 col-lg-7" style="padding-top: 1px; padding-left: 0px; padding-right: 0px;">
            <h4>{{ $video->title }}</h4>
            <p>觀看次數：{{ $video->views() }}次</p>
            <p style="margin-top: 9px; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="hidden-xs hidden-sm">{{ $video->caption }}</p>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align: right;">
            <h5 style="margin-top: 8px;">no.</h5>
        </div>
    </div>
</a>
<hr style="margin: 15px 0px;">
<div id="singleRankVideo" class="multiple-link-wrapper">
    <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="overlay"></a>
    <div class="row inner">
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3" style="padding-right: 5px">
            <img class="lazy" style="border-radius: 5px; width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
        </div>
        <div class="col-xs-6 col-sm-6 col-md-8 col-lg-9" style="padding-top: 0px; padding-left: 5px;">
            <h4>{{ $video->title }}</h4>
            <p>
            @if ($video->category == 'video')
              {{ $video->genre() }} • 
            @else
              <a class="text-ellipsis-mobile" href="{{ route('video.intro', [$video->genre, $video->watch()->titleToUrl()]) }}">{{ $video->watch()->title }} • </a>
            @endif
            觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }}</p>
            <p style="margin-top: 9px; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="hidden-xs hidden-sm">{{ $video->caption }}</p>
        </div>
    </div>
<hr style="margin: 10px 0px;">
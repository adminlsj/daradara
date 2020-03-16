<div id="singleSearchVideo" style="padding: 7px 0px;" class="multiple-link-wrapper">
  <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="overlay"></a>
  <div class="row no-gutter inner">
    <div class="col-xs-6 col-sm-6 col-md-3">
      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
      <span>{{ $video->duration() }}</span>
    </div>
    <div style="padding-top: 1px; padding-right: 12px; padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-7">
      <h4>{{ $video->title }}</h4>
      <p>
        @if ($video->category == 'video')
          {{ $video->genre() }}
        @else
          <a href="{{ route('video.intro', [$video->genre, $video->watch()->titleToUrl()]) }}">{{ $video->watch()->title }}</a>
        @endif
         • <br class="hidden-md hidden-lg">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }}</p>
      <p style="margin-top: 9px; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="hidden-xs hidden-sm">{{ $video->caption }}</p>
    </div>
  </div>
</div>
<div id="singleSearchVideo" style="padding: 7px 0px;" class="multiple-link-wrapper hover-opacity-all">
  <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="overlay"></a>
  <div class="row no-gutter inner">
    <div class="col-xs-6 col-sm-6 col-md-3">
      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
    </div>
    <div style="padding-top: 1px; padding-right: 12px; padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-7">
      <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $video->title }}</h4>
      <p>
        <a class="text-ellipsis-mobile" href="{{ route('user.show', $video->user->id) }}">{{ $video->user->name }} • </a><span class="text-ellipsis-mobile">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }}</p></span>
      <p style="margin-top: 9px; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="hidden-xs hidden-sm">{{ $video->caption }}</p>
    </div>
  </div>
</div>
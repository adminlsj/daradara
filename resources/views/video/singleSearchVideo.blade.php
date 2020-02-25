<div id="singleSearchVideo" style="padding: 7px 0px;">
  <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="row no-gutter">
    <div style="padding-left: 12px; padding-right: 4px; position: relative;" class="col-xs-6 col-sm-6 col-md-3">
      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
      <span style="position: absolute; bottom:6px; right: 9px; background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px;">{{ $video->duration() }}</span>
    </div>
    <div style="padding-top: 1px; padding-right: 12px; padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-7">
      <h4>{{ $video->title }}</h4>
      <p>觀看次數：{{ $video->views() }}次</p>
      <p style="margin-top: 9px; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="hidden-xs hidden-sm">{{ $video->caption }}</p>
    </div>
  </a>
</div>
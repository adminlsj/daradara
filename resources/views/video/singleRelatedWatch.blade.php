<a href="{{ route('video.watch') }}?v={{ $video->id }}{{ $source == 'playlist' ? '&list='.Request::get('list') : '' }}" class="row no-gutter hover-opacity-all">
  <div style="padding-right: 4px; position: relative;" class="col-xs-6 col-sm-6 col-md-6">
    <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
  </div>
  <div style="padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
    <h4 style="margin-top:0px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em; color:#222222;">{{ $video->title }}</h4>
    <p style="color: dimgray; margin-top: 3px; margin-bottom: 0px; font-size: 0.85em;">{{ $video->user()->name }}</p>
  </div>
</a>
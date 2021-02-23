<a href="{{ route('video.watch') }}?v={{ $video->id }}{{ $source == 'playlist' ? '&list='.Request::get('list') : '' }}" class="row no-gutter">
  <div style="padding-right: 0px; width: 198px; max-width: 50%;" class="col-xs-6 col-sm-6 col-md-6">
    <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
  </div>
  <div style="width: calc(100% - 198px); min-width: 50%;" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
    <h4 style="font-weight: 600; color: white;">{{ $video->title }}</h4>
    <p style="color: #bdbdbd; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.9em; margin-top: 5px; margin-bottom: 1px; font-weight: 400 !important;">觀看次數：{{ $video->views() }}次</p>
    <p style="color: #bdbdbd; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.9em; font-weight: 400 !important;">{{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}</p>
  </div>
</a>
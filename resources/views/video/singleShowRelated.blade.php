<a href="{{ route('video.watch') }}?v={{ $video->id }}" class="row no-gutter">
  <div style="padding-right: 0px; width: 160px; max-width: 50%; position: relative;" class="col-xs-6 col-sm-6 col-md-6">
    <img style="width: 100%; height: 100%;" src="https://i.imgur.com/JMcgEkPt.jpg">
    @if ($video->id == $current->id)
	    <img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; filter: brightness(15%);" src="{{ $video->imgurM() }}" alt="{{ $video->title }}">
	    <div style="margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-weight: bold">現正播放</div>
	  @else
		  <img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="{{ $video->imgurM() }}" alt="{{ $video->title }}">
    @endif
  </div>
  <div style="width: calc(100% - 160px); min-width: 50%; max-height: 90px;" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
    <h4 style="font-weight: 600; color: white;">{{ $video->title }}</h4>
    <p style="color: #bdbdbd; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.89em; margin-top: 4px; margin-bottom: 0px; font-weight: 400 !important;">觀看次數：{{ $video->views() }}次</p>
  </div>
</a>
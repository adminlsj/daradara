<div style="padding: 7px 0px;">
  <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="row no-gutter">
    <div style="padding-left: 12px; padding-right: 4px; position: relative;" class="col-xs-6 col-sm-6 col-md-6">
      <img style="width: 100%; height: 100%;" src="{{ $video->imgurL() }}" alt="{{ $video->title }}">
      <span style="position: absolute; bottom:6px; right: 9px; background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px;">{{ $video->duration() }}</span>
    </div>
    <div style="padding-top: 1px; padding-right: 12px; padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-6">
      <h4 style="margin-top:0px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em; color:#323232">{{ $video->title }}</h4>
      <p style="color: gray; margin-top: 1px; margin-bottom: 0px; font-size: 0.85em;">觀看次數：{{ $video->views() }}次</p>
    </div>
  </a>
</div>
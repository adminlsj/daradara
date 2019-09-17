<div style="margin-bottom: 15px;">
  <a href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}" class="row no-gutter">
    <div style="padding-left: 15px; padding-right: 3px;" class="col-xs-6 col-sm-6 col-md-6">
      <img src="{{ $video->blogImgs[0]->thumbnail }}" width="100%" height="100%">
    </div>
    <div style="padding-top: 2px; padding-right: 15px; padding-left: 3px;" class="col-xs-6 col-sm-6 col-md-6">
      <h4 style="font-weight: 600; margin-top:0px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em;">{{ $video->title }}</h4>
      <p style="color: gray; margin-top: 2px; margin-bottom: 0px; font-size: 0.85em;">觀看次數：{{ $video->views() }}次</p>
    </div>
  </a>
</div>
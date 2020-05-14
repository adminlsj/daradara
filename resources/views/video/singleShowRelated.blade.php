<a href="{{ route('video.watch') }}?v={{ $video->id }}{{ $source == 'playlist' ? '&list='.Request::get('list') : '' }}" class="row no-gutter">
  <div style="padding-right: 4px; position: relative; width: 175px;" class="col-xs-6 col-sm-6 col-md-6">
    <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
  </div>
  <div style="padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-6 related-watch-title" style="position: relative;">
    <h4>{{ $video->title }}</h4>
  </div>
</a>

<div style="position: absolute; bottom: 7px; left: 182px;">
	<img class="lazy" style="float:left; width: 18px; height: 18px; margin-top: 1px" src="{{ $video->user()->avatarCircleB() }}" data-src="{{ $video->user()->avatar == null ? $video->user()->avatarDefault() : $video->user()->avatar->filename }}" data-srcset="{{ $video->user()->avatar == null ? $video->user()->avatarDefault() : $video->user()->avatar->filename }}">
	<a href="{{ route('user.show', [$video->user()]) }}" style="color: darkgray; font-size: 0.8em; margin-left: 5px;">{{ $video->user()->name }}</a>
</div>
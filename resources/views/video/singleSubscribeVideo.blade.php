<div class="hidden-md hidden-lg" style="margin-bottom: 30px;">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;">
		<img class="lazy" style="width: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurH() }}" alt="{{ $video->title }}">
	</a>

	<div class="padding-setup" style="margin-top: 10px">
		<a href="{{ route('video.intro', [$video->genre, $video->watch()->titleToUrl()]) }}" style="text-decoration: none;">
			<img style="width: 45px; height: auto; float: left; border-radius: 50%;" src="https://i.imgur.com/{{ $video->watch()->imgur }}s.jpg" alt="{{ $video->watch()->title }}">
		</a>
		<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; color: black;">
			<div style="margin-left: 53px; font-size: 1.1em; line-height: 19px">{{ $video->title }}</div>
			<div style="margin-left: 53px; font-size: 0.85em; color: #595959; margin-top: 3px;">{{ $video->watch()->title }} • 收看次數：{{ $video->views() }} • {{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }}</div>
		</a>
	</div>
</div>

<div id="singleSubscribeVideo" style="padding: 7px 20px;" class="multiple-link-wrapper hidden-xs hidden-sm">
  <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="overlay"></a>
  <div class="row no-gutter inner">
    <div class="col-xs-6 col-sm-6 col-md-3">
      <img class="lazy" style="width: 100%; height: 100%; padding-right: 13px" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
      <span>{{ $video->duration() }}</span>
    </div>
    <div style="padding-top: 1px; padding-right: 12px; padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-7">
      <h4>{{ $video->title }}</h4>
      <p><a href="{{ route('video.intro', [$video->genre, $video->watch()->titleToUrl()]) }}">{{ $video->category == 'video' ? $video->genre : $video->watch()->title }}</a> • <br class="hidden-md hidden-lg">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }}</p>
      <p style="margin-top: 9px; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="hidden-xs hidden-sm">{{ $video->caption }}</p>
    </div>
  </div>
</div>
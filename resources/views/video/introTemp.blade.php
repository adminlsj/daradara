<div class="{{ $watch->genre == 'variety' ? 'col-xs-8 col-xs-offset-2' : 'col-xs-6 col-xs-offset-3' }} col-md-3 col-md-offset-0">
	<img class="lazy" style="width: 100%; height: 100%; border-radius: 3px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.5); margin-top: 1px" src="{{ $watch->imgurDefaultIntro() }}" data-src="{{ $watch->imgurH() }}" data-srcset="{{ $watch->imgurH() }}" alt="{{ $watch->title }}">

	<div style="margin-top: 10px" class="visible-xs visible-sm"></div>
</div>
<div class="col-xs-12 col-sm-12 col-md-9">
	<h4 class="mobile-text-center" style="margin-top:5px; margin-bottom: 0px; line-height: 24px; font-size: 1.5em; font-weight: bold; color: white;">{{ $watch->title }}</h4>

	<div class="mobile-text-center" style="font-size: 0.95em; margin-top: 5px; color: #f5f5f5">上傳用戶：<a style="color: #f5f5f5" href="{{ route('user.show', $watch->user()) }}">{{ $watch->user()->name }}</a></div>

	<div class="row no-gutter" style="margin-top: 25px">
    	<div id="intro-play-button" class="col-xs-8 col-md-4" style="padding-right: 3px;">
    		<a style="color: white; margin-top: -15px; margin-bottom: 0px;" @if($videos->first() != null)href="{{ route('video.watch') }}?v={{ $videos->first()->id }}"@endif class="btn btn-info" target="_blank">
				<i style="vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: 3px; margin-left: -3px" class="material-icons">play_arrow</i>立即播放
			</a>
    	</div>
    	<div class="col-xs-4 col-md-2" style="width: 80px">
    		@if (!$is_background)
    			@include('video.intro-subscribe-wrapper', ['tag' => $watch->title])
    		@endif
		</div>
	</div>

	<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 0.95em;">{{ $watch->description }}</h4>

	<div style="padding: 0px 0px; position: relative; padding-right: 40px; width: 100%;" class="subscribes-tab-inverse subscribe-tags-wrapper">
	  @foreach (explode(' ', $watch->cast) as $tag)
	      <a style="margin-right: 3px; text-decoration: none; display: inline-block; margin-bottom: 10px; padding: 5px 10px; font-size: 0.9em" href="{{ route('video.subscribeTag') }}?query={{ $tag }}">#{{ $tag }}</a>
	  @endforeach
	</div>
</div>
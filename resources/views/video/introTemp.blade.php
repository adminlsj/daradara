<div class="col-xs-6 col-md-3 col-md-offset-0">
	<img class="lazy" style="width: 100%; height: 100%; border-radius: 3px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.5); margin-top: 3px;" src="{{ $watch->imgurDefaultIntro() }}" data-src="{{ $watch->imgurH() }}" data-srcset="{{ $watch->imgurH() }}" alt="{{ $watch->title }}">

	<div style="margin-top: 10px" class="visible-xs visible-sm"></div>
</div>
<div class="col-xs-6 col-sm-6 col-md-9" style="padding-left: 0px">
	<h4 style="margin-top:5px; margin-bottom: 0px; line-height: 24px; font-size: 1.3em; font-weight: bold; color: white;">{{ $watch->title }}</h4>

	<div style="margin-top: 10px; color:#d3d3d3;"><a style="color:#d3d3d3;" href="{{ route('user.show', $watch->user()) }}">{{ $watch->user()->name }}</a> • </div>
	<div style="color:#d3d3d3;">@if ($watch->genre == 'variety')每週{{ App\Video::transDayOfWeek(Carbon\Carbon::parse($watch->created_at )->dayOfWeek) }}晚間播放 • {{ Carbon\Carbon::parse($watch->updated_at)->diffForHumans().'更新' }}
		@else{{ Carbon\Carbon::parse($watch->created_at )->format('Y年m月d日首播') }} • {{ $watch->is_ended ? '已完結全' : '更新至第'.$watch->videos()->count().'集' }}
		@endif
    </div>

    <div id="subscribe-panel" style="float: left; margin-top: 40px; font-size: 0.85em">
      @if ($is_subscribed)
        @include('video.unsubscribeBtn')
      @else
        @include('video.subscribeBtn')
      @endif
    </div>
</div>
<div style="margin-top: 15px" class="col-xs-12 col-sm-12 col-md-9">
    <div class="intro-play-btn" style="width: 100%">
		<a style="color: white; margin-top: -15px; margin-bottom: 0px;" href="{{ route('video.watch') }}?v={{ $videos->first()->id }}" class="btn btn-info" target="_blank">
			<i style="vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">play_arrow</i>&nbsp;&nbsp;立即播放
		</a>
	</div>

	<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 0.95em;">{{ $watch->description }}</h4>
	<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 1.2em; padding-top: 5px;">登場人物</h4>
	<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 0.95em; margin-top: -4px;">{{ $watch->cast }}</h4>
</div>
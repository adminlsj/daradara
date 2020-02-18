<div class="{{ $watch->genre == 'variety' ? 'col-xs-8 col-xs-offset-2' : 'col-xs-6 col-xs-offset-3' }} col-md-3 col-md-offset-0">
	<img class="lazy" style="width: 100%; height: 100%; border-radius: 3px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.5);" src="https://i.imgur.com/sMSpYFXh.jpg" data-src="{{ $watch->imgurH() }}" data-srcset="{{ $watch->imgurH() }}" alt="{{ $watch->title }}">

	<div style="margin-top: 10px" class="visible-xs visible-sm"></div>
</div>
<div class="col-xs-12 col-sm-12 col-md-9">
	<h4 class="mobile-text-center" style="margin-top:5px; margin-bottom: 0px; line-height: 24px; font-size: 1.3em; font-weight: bold; color: white;">{{ $watch->title }}</h4>

	<h4 class="mobile-text-center" style="margin-top:5px; white-space: pre-wrap;color:#d3d3d3; line-height: 15px; font-size: 0.95em; font-weight: 300;">{{ Carbon\Carbon::parse($watch->created_at )->format('Y年m月d日首播') }}  |  {{ $watch->genre == 'variety' ? Carbon\Carbon::parse($watch->updated_at)->diffForHumans().'更新' : ($watch->is_ended ? '已完結全' : '更新至第'.$watch->videos()->count().'集') }}
    </h4>

	<a style="color: white; margin-top: -15px; margin-bottom: 0px;" href="{{ route('video.watch') }}?v={{ $videos->first()->id }}" class="btn btn-info" target="_blank">
		<i style="vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">play_arrow</i>&nbsp;&nbsp;立即播放
	</a>

	<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 0.95em;">{{ $watch->description }}</h4>
	<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 1.2em; padding-top: 5px;">登場人物</h4>
	<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 0.95em; margin-top: -4px;">{{ $watch->cast }}</h4>
</div>
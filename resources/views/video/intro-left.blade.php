<div style="position: relative; text-align: center" class="hover-opacity-all">
	<a href="{{ $link }}">
		<img class="lazy" style="width: 100%; height: 100%;" src="https://i.imgur.com/JMcgEkPl.jpg" data-src="{{ $image }}" data-srcset="{{ $image }}" alt="{{ $title }}">
		<div style="position: absolute; bottom: 0px; color: white; background-color: rgba(0, 0, 0, .8); width: 100%; height: 40px; padding-top: 10px"><i style="vertical-align:middle; font-size: 1.95em; margin-top: -3px; margin-right: 7px; margin-left: -3px" class="material-icons">play_arrow</i><span style="font-size: 1.05em; font-weight: 500">全部播放</span></div>
	</a>
</div>
<h3>{{ $watch->title }}</h3>
<h5 style="color: dimgray; font-weight: 400; margin-top: 15px">{{ $videos->count()}} 部影片 <small>•</small> {{ Carbon\Carbon::parse($watch->updated_at)->diffForHumans() }}更新</h5>
<h5 style="color: dimgray; font-weight: 400; margin-top: 15px; line-height: 20px">{{ $watch->description }}</h5>
<hr style="border-color: #e1e1e1;">
<a href="{{ route('user.show', [$watch->user()]) }}"><img class="lazy" style="float:left; border-radius: 50%; width: 50px; height: 50px;" src="{{ $watch->user()->avatarCircleB() }}" data-src="{{ $watch->user()->avatar == null ? $watch->user()->avatarDefault() : $watch->user()->avatar->filename }}" data-srcset="{{ $watch->user()->avatar == null ? $watch->user()->avatarDefault() : $watch->user()->avatar->filename }}"></a>
<h5 style="margin-top: 38px; margin-left: 65px"><a style="text-decoration: none; color: #222222" href="{{ route('user.show', [$watch->user()]) }}">{{ $watch->user()->name }}</a></h5>
<div style="float: right; margin-top: -25px; width: 75px">
	@include('video.intro-subscribe-wrapper', ['tag' => $watch->title])
</div>
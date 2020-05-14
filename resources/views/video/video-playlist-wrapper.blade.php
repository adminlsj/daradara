@if ($videos)
	<div style="margin: 10px 15px 15px 15px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); border-radius: 3px;">
		<div style="background-color: #e1e1e1; padding: 10px; border-top-left-radius: 3px; border-top-right-radius: 3px;">
			<div><a style="color: #222222; font-weight: bold; font-size: 1.1em" href="{{ route('video.playlist') }}?list={{ $current->watch()->id }}">{{ $current->watch()->title }}</a></div>
			<div><a style="color: dimgray; font-weight: bold; font-size: 0.85em" href="{{ route('user.show', [$current->user()]) }}">{{ $current->user()->name }}</a></div>
		</div>

		<div class="playlist-scoll-wrapper" style="max-height: 325px; overflow-y: scroll; padding: 5px 0px; background-color: #F9F9F9; border-bottom-left-radius: 3px; border-bottom-right-radius: 3px;">
			@foreach ($videos as $video)
			    <div class="hover-opacity-all" style="{{ $video->id == $current->id ? 'background-color: #e9e9e9' : '' }}; padding: 5px 10px;">
			    	<a href="{{ route('video.watch') }}?v={{ $video->id }}&list={{ Request::get('list') }}" class="row no-gutter">
					  <div style="padding-right: 4px; position: relative;" class="col-xs-4 col-sm-4 col-md-4">
					    <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
					  </div>
					  <div style="padding-left: 4px;" class="col-xs-8 col-sm-8 col-md-8" style="position: relative;">
					    <h4 style="font-size: 1.0em; font-weight: bold; margin-top: 0px; color: #444444; line-height: 19px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $video->title }}</h4>
					  </div>
					</a>
				</div>
			@endforeach
		</div>
	</div>
@endif

@foreach ($related as $video)
    <div class="related-watch-wrap hover-opacity-all" style="background-color: #F9F9F9">
    	@include('video.singleShowRelated', ['source' => 'video'])
	</div>
@endforeach
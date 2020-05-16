<div class="row paravi-padding-setup" style="padding-top: 15px; margin-bottom: -3px;">
	<div style="padding: 0px 15px;">
		@foreach ($videos as $video)
			@if ($loop->iteration == 1)
				<div class="col-xs-12 col-sm-6 col-md-6 hover-opacity-all load-more-wrapper" style="margin-bottom: 9px; width: calc(60% - 3px);">
				    <div style="position: relative;">
					    <a href="{{ route('video.watch') }}?v={{ $video->id }}">
					      <img class="lazy" style="width: 100%; height: 100%; border-radius: 3px;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurH() }}" alt="{{ $video->title }}">
					      <div class="single-load-more-video-wrapper" style="border-bottom-left-radius: 3px; border-bottom-right-radius: 3px;">
					        <div style="font-size: 0.9em; font-weight: bold;">{{ $video->user()->name }}</div>
					        <div style="margin-top: 1px; font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-size: 1.5em">{{ $video->title }}</div>
					      </div>
					    </a>
					</div>
				</div>

			@else
				<div class="col-xs-12 col-sm-3 col-md-3 hover-opacity-all load-more-wrapper" style="margin-bottom: 9px; width: calc(20%); padding-left: 14px !important; padding-right: 1px !important">
				    <div style="position: relative;">
					    <a href="{{ route('video.watch') }}?v={{ $video->id }}">
					      <img class="lazy" style="width: 100%; height: 100%; border-radius: 3px;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurH() }}" alt="{{ $video->title }}">
					      <div class="single-load-more-video-wrapper" style="border-bottom-left-radius: 3px; border-bottom-right-radius: 3px;">
					        <div style="margin-top: 1px; font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{ $video->title }}</div>
					      </div>
					    </a>
					</div>
				</div>

			@endif
		@endforeach
	</div>
</div>
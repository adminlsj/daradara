<a style="text-decoration: none;" href="{{ $link }}">
	<h3>{{ $title }}</h3>
</a>
<div style="position: relative;">
	@include('layouts.card-navigate-before')
	<div class="home-rows-videos-wrapper no-scrollbar-style" style="margin-left: 0px; margin-right: -3px;">
		@foreach ($videos as $video)
			<div class="multiple-link-wrapper search-doujin-videos home-doujin-videos hidden-xs" style="display: inline-block; padding-right: 3px;">
				<a class="overlay" href="{{ $video['link'] }}"></a>
				<div class="card-mobile-panel inner">
					<div style="position: relative;">
						<img style="width: 100%;" src="https://i.imgur.com/VrTRZpk.jpg">
						<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 3px" src="{{ $video['imgur'] }}">
				    </div>

					<div style="margin-top: -1px; padding: 0 3px;">
						<div style="text-decoration: none; color: black;">
							<div class="card-mobile-title" style="font-weight: normal; color: #e5e5e5;">{{ $video['title'] }}</div>

							<div class="card-mobile-genre-wrapper" style="margin-left: -2px">
								<a style="font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user">{{ $video['total'] }} 部影片</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="multiple-link-wrapper search-doujin-videos home-doujin-videos hidden-sm hidden-md hidden-lg hidden-xl" style="display: inline-block; padding-right: 4px;">
				<a class="overlay" href="{{ $video['link'] }}"></a>
				<div class="card-mobile-panel inner">
					<div style="position: relative;">
						<img style="width: 100%;" src="https://i.imgur.com/VrTRZpk.jpg">
						<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 3px" src="{{ $video['imgur'] }}">
				    </div>

					<div style="padding: 0 3px;">
						<div style="text-decoration: none; color: black;">
							<div class="card-mobile-title" style="margin-top: 7px; font-weight: normal; color: #e5e5e5; padding: 0px; font-size: 12px">{{ $video['title'] }}</div>

							<div class="card-mobile-genre-wrapper" style="margin-left: -2px; padding: 0px; margin-top: -1px;">
								<a style="font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block; font-weight: normal !important;" class="card-mobile-user">{{ $video['total'] }} 部影片</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	@include('layouts.card-navigate-after')
</div>
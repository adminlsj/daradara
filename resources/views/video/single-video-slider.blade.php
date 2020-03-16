@if ($is_mobile)
	<div id="custom-scroll-slider">
	    @foreach ($videos as $video)
	        <div class="multiple-link-wrapper" style="width: 250px !important; display: inline-block; vertical-align: text-top;">
			    <a style="text-decoration: none; color: black" class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
			    <img class="lazy" style="border-radius: 3px; width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">

			    <div class="inner" style="height: 66px; margin-top: -4px;">
			      <h4 style="line-height: 19px; font-size: 1.05em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-weight: 400; color: black; white-space: initial;">{{ $video->title }}</h4>
			      <p style="font-size: 0.9em; margin-top: -9px; color: #595959">@if ($video->category == 'video'){{ $video->genre() }}@else<a href="{{ route('video.intro', [$video->genre, $video->watch()->titleToUrl()]) }}">{{ str_limit($video->watch()->title, 30) }}</a>@endif • {{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }}</p>
			    </div>
			</div>
	    @endforeach
	</div>

@else
	<div class="row no-gutter" style="padding: 0px 15px">
        @foreach ($videos as $video)
          <div style="padding: 0px 5px; margin-bottom: 7px" class="col-md-3 multiple-link-wrapper">
              <a style="text-decoration: none; color: black" class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
              <img class="lazy" style="border-radius: 3px; width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">

              <div class="inner" style="height: 66px; margin-top: -4px;">
                <h4 style="line-height: 19px; font-size: 1.05em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-weight: 400; color: black">{{ $video->title }}</h4>
                <p style="font-size: 0.9em; margin-top: -9px; color: #595959">@if ($video->category == 'video'){{ $video->genre() }}@else<a href="{{ route('video.intro', [$video->genre, $video->watch()->titleToUrl()]) }}">{{ str_limit($video->watch()->title, 30) }}</a>@endif • {{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }}</p>
              </div>
          </div>
        @endforeach
    </div>

@endif
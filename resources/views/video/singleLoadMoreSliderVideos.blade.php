<div class="col-xs-6 col-sm-3 col-md-3 hover-opacity load-more-wrapper">
    <a style="text-decoration: none; color: black" class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}">
		<img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">

		<div class="hover-underline">
		    <h4 class="text-ellipsis" style="padding-right: 10px">@if ($video->watch()){{ $video->watch()->title }}@endif {{ $video->title }}</h4>
		</div>
    </a>
</div>
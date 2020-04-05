<div class="col-xs-6 col-sm-3 col-md-2 hover-opacity load-more-wrapper">
    <a style="text-decoration: none; color: black" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">
		<img class="lazy" style="width: 100%; height: 100%;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">

		<div class="hover-underline">
		    <h4 style="font-size: 0.95em; margin-top: 7px; color: #222222;" class="text-ellipsis">{{ $watch->title }}</h4>
		</div>
    </a>
</div>
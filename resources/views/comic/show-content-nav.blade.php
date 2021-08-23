<div class="comic-show-content-nav" style="background-color: #383838; text-align: center">
	<a style="display: inline-block; float: left;" href="{{ route('comic.showCover', ['comic' => $comic]) }}">
		<span style="color: white; font-size: 20px; vertical-align: middle; margin-top: 0px; padding: 9px;" class="material-icons comic-show-content-nav-item">reply</span>
	</a>

	<a class="comic-show-content-nav-item-wrapper fast-rewind" href="{{ route('comic.showContent', ['comic' => $comic, 'page' => 1]) }}" data-id="{{ $comic->galleries_id }}" data-page="1">
		<span style="color: white; font-size: 22px; vertical-align: middle; margin-right: -4px; margin-top: 0px; padding: 8px 9px 8px 7px;" class="material-icons comic-show-content-nav-item">fast_rewind</span>
	</a>

	<a class="comic-show-content-nav-item-wrapper arrow-left" href="{{ route('comic.showContent', ['comic' => $comic, 'page' => $page - 1]) }}" data-id="{{ $comic->galleries_id }}" data-page="{{ $page - 1 }}">
		<span style="color: white; font-size: 28px; vertical-align: middle; margin-right: 10px; margin-top: 0px; padding: 5px;" class="material-icons comic-show-content-nav-item">arrow_left</span>
	</a>

	<span style="color: white; font-size: 14px; line-height: 30px"><span class="current-page-number">{{ $page }}</span><span style="font-weight: 400"> / </span>{{ $comic->pages }}
	</span>

	<a class="comic-show-content-nav-item-wrapper arrow-right" href="{{ route('comic.showContent', ['comic' => $comic, 'page' => $page + 1]) }}" data-id="{{ $comic->galleries_id }}" data-page="{{ $page + 1 }}">
		<span style="color: white; font-size: 28px; vertical-align: middle; margin-left: 10px; margin-top: 0x; padding: 5px;" class="material-icons comic-show-content-nav-item">arrow_right</span>
	</a>

	<a class="comic-show-content-nav-item-wrapper fast-forward" href="{{ route('comic.showContent', ['comic' => $comic, 'page' => $comic->pages]) }}" data-id="{{ $comic->galleries_id }}" data-page="{{ $comic->pages }}">
		<span style="color: white; font-size: 22px; vertical-align: middle; margin-left: -4px; margin-top: 0px; padding: 8px 7px 8px 9px;" class="material-icons comic-show-content-nav-item">fast_forward</span>
	</a>
</div>
<div class="no-select comic-show-content-nav" style="background-color: #383838; position: relative; height: 38px;" data-id="{{ $comic->galleries_id }}" data-pages="{{ $comic->pages }}">
	<div style="display: inline-block; position: absolute; left: 0; width: auto; z-index: 1;">
		<a href="{{ route('comic.showCover', ['comic' => $comic]) }}">
			<span style="color: white; font-size: 20px; vertical-align: middle; margin-top: 0px; padding: 9px;" class="material-icons comic-show-content-nav-item">reply</span>
		</a>
	</div>

	<div style="margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%; text-align: center;">
		<a class="no-select comic-show-content-nav-item-wrapper fast-rewind {{ $page == 1 ? 'comic-nav-hidden' : '' }}" href="{{ route('comic.showContent', ['comic' => $comic, 'page' => 1]) }}" data-page="1">
			<span style="font-size: 22px; vertical-align: middle; margin-right: -4px; margin-top: 0px; padding: 8px 9px 8px 8px;" class="material-icons comic-show-content-nav-item">fast_rewind</span>
		</a>

		<a class="no-select comic-show-content-nav-item-wrapper arrow-left {{ $page == 1 ? 'comic-nav-hidden' : '' }}" href="{{ route('comic.showContent', ['comic' => $comic, 'page' => $page - 1]) }}" data-id="{{ $comic->galleries_id }}" data-page="{{ $page == 1 ? 1 : $page - 1 }}">
			<span style="font-size: 28px; vertical-align: middle; margin-right: 10px; margin-top: 0px; padding: 5px;" class="material-icons comic-show-content-nav-item">arrow_left</span>
		</a>

		<span class="no-select" style="color: white; font-size: 14px; line-height: 30px"><span class="current-page-number">{{ $page }}</span><span style="font-weight: 400"> / </span>{{ $comic->pages }}
		</span>

		<a class="no-select comic-show-content-nav-item-wrapper arrow-right {{ $page == $comic->pages ? 'comic-nav-hidden' : '' }}" href="{{ route('comic.showContent', ['comic' => $comic, 'page' => $page + 1]) }}" data-id="{{ $comic->galleries_id }}" data-page="{{ $page == $comic->pages ? $comic->pages : $page + 1 }}">
			<span style="font-size: 28px; vertical-align: middle; margin-left: 10px; margin-top: 0x; padding: 5px;" class="material-icons comic-show-content-nav-item">arrow_right</span>
		</a>

		<a class="no-select comic-show-content-nav-item-wrapper fast-forward {{ $page == $comic->pages ? 'comic-nav-hidden' : '' }}" href="{{ route('comic.showContent', ['comic' => $comic, 'page' => $comic->pages]) }}" data-id="{{ $comic->galleries_id }}" data-page="{{ $comic->pages }}">
			<span style="font-size: 22px; vertical-align: middle; margin-left: -4px; margin-top: 0px; padding: 8px 8px 8px 9px;" class="material-icons comic-show-content-nav-item">fast_forward</span>
		</a>
	</div>

	<div style="display: inline-block; position: absolute; right: 0; width: auto; z-index: 1;">
		<a class="comics-content-zoom-out">
			<span style="color: white; font-size: 22px; vertical-align: middle; margin-top: 0px; padding: 8px;" class="material-icons comic-show-content-nav-item">zoom_out</span>
		</a>
		<span class="zoom-ratio" style="color: white; font-weight: 400; padding-left: 7px; padding-right: 7px;">{{ isset($_COOKIE['zoom']) ? $_COOKIE['zoom'] : 1 }}.0x</span>
		<a class="comics-content-zoom-in">
			<span style="color: white; font-size: 22px; vertical-align: middle; margin-top: 0px; padding: 8px;" class="material-icons comic-show-content-nav-item">zoom_in</span>
		</a>
	</div>
</div>
<div class="hidden-sm hidden-md hidden-lg hidden-xl video-buttons-wrapper desktop-inline-mobile-block hide-scrollbar" style="position: absolute; top: 40px; transition: top 0.5s; width: 100%; text-align: center; z-index: 99; height: 40px; line-height: 40px; overflow-y: hidden; padding: 0 15px;">
	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#genre-modal">
		<span style="{{ !$genre || $genre == '全部' ? '' : 'background-color: rgba(255,255,255,.3)' }}" class="home-genre-tabs">{{ !$genre || $genre == '全部' ? '全部類型' : Request::get('genre')}}<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://vdownload.hembed.com/image/icon/arrow_down.png?secure=2CKFWyW8NLKoTjn7Szq8lw==,4855470564"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#tags">
		<span style="{{ !$tags || $tags == '[]' ? '' : 'background-color: rgba(255,255,255,.3)' }}" class="home-genre-tabs">標籤<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://vdownload.hembed.com/image/icon/arrow_down.png?secure=2CKFWyW8NLKoTjn7Szq8lw==,4855470564"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#sort-modal">
		<span style="{{ $sort ? 'background-color: rgba(255,255,255,.3)' : '排序方式'}}" class="home-genre-tabs">{{ $sort ? $sort : '排序方式'}}<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://vdownload.hembed.com/image/icon/arrow_down.png?secure=2CKFWyW8NLKoTjn7Szq8lw==,4855470564"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#date-modal" >
		<span style="{{ $year ? 'background-color: rgba(255,255,255,.3)' : ''}}" class="home-genre-tabs">發佈日期<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://vdownload.hembed.com/image/icon/arrow_down.png?secure=2CKFWyW8NLKoTjn7Szq8lw==,4855470564"></span>
	</div>

	<div class="home-genre-tabs-wrapper search-type-button" style="margin-right: 0px;">
		<span class="home-genre-tabs">
			<span class="search-type-input">搜尋作者</span>
			<img style="width: 11px; margin-top: -3px; margin-left: 2px" src="https://vdownload.hembed.com/image/icon/search_artist_icon.jpg?secure=qYBLGsqhJQrL4DsgOnOPkA==,4853050902">
		</span>
	</div>
</div>
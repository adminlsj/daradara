@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original-dark', ['theme' => 'white'])
@endsection

@section('content')

<div class="paravi-padding-setup" style="padding-top: 65px; background-color: #303030">
	<div style="text-align: center; {{ $videos->count() > 48 ? 'margin-bottom: -15px' : '' }}">{!! $videos->render() !!}</div>
	<div class="row hentai-row-wrapper" style="margin-top: 20px;">
		@foreach ($videos as $video)
			<div class="col-xs-4 col-sm-3 col-md-2">
				<a href="/watch?v={{ $video->id }}" style="text-decoration: none;" class="hover-opacity-all" title="{{ $video->title }}">
					<img class="lazy" style="border-radius: 3px; width: 100%; height: 100%;" src="{{ App\Image::$portrait }}" data-src="{{ $video->cover }}" data-srcset="{{ $video->cover }}" alt="{{ $video->title }}">
					<div style="height: 65px; padding: 4px 1px; color: #fff; font-size: 0.95em; line-height: 19px;"><span style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</span></div>
				</a>
			</div>
		@endforeach
	</div>
	<div style="text-align: center;">{!! $videos->render() !!}</div>
</div>

<div class="paravi-padding-setup" style="background-color: #212121; color: gray; padding-top: 20px; padding-bottom: 10px;">
	<p>LaughSeeJapan hentai haven 帶給你最新最全的無碼高清中文字幕Hentai成人動漫。我們提供最優質的Hentai色情動漫裏番，並以最高畫質1080p呈現的Blu-ray rip。我們的18禁H漫網站適用於手機設備，並提供全網最優質的Hentai動畫。最新最全的Hentai裏番資料庫，LaughSeeJapan hentai 讓你觀賞一個按鈕觀看所有Hentai成人動漫，包括最新的2020年Hentai成人動漫。在這裏，你可以找到最優質的中文字幕Hentai 24小時！免費享受hentai動漫，成人動畫，H漫，並且更有中文字幕，不必再聽日語猜故事！這個網站是亞洲最優質的色情工口Hentai成人動漫，並且有許多Hentai分類，包括顏射、乳交、口交、熟女、學生妹、中出、百合、肛交，以及更多！</p>

	<p>Hentai是什麼？Hentai（変態 或 へんたい），Hentai 或 成人動漫的詞源來自日本，並指色情或成人動漫和動畫，特別是來自日本的18禁H漫和成人動畫。</p>
</div>

@endsection
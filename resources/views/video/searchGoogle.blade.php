@extends('layouts.app')

@section('head')
    @parent
    <title>{{ Request::get('q') }} | 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ Request::get('q') }} | 娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫">
    <meta name="description" 
              content="日本最強娛樂，最新綜藝！從綜藝到日劇和動漫，娛見日本 LaughSeeJapan 包攬最新最全的日娛王道！從搞笑到感動，從笑梗到溫情，從寵物到家庭，這裡可以找到讓你大笑，讓你痛哭，讓你重拾失去的情感，讓你回歸最原始的自己！這裡是日本，最強娛樂，最新綜藝，以及人文與文化！">
@endsection

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray", 'menuBtnColor' => '#595959'])
@endsection

@section('content')
<div class="row">
	<div class="col-lg-2 col-md-2 hidden-sm hidden-xs sidebar-menu">
		@include('video.sidebarMenu', ['theme' => 'white'])
	</div>

	<div class="col-md-10 col-md-offset-2">
		<div style="background-color: white" class="padding-setup">
			<div style="margin-left: -14px; margin-right: -14px; overflow-y: hidden;">
			    <script async src="https://cse.google.com/cse.js?cx=004204537983416081067:6ev1yqb2x3e"></script>
				<div class="gcse-search"></div>
			</div>
		</div>
	</div>
</div>
@endsection
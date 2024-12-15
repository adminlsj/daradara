@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<form id="hentai-form" action="{{ route('anime.search') }}" method="GET">
	<div class="flex-center-wrapper home-wrapper">
		<div class="flex-center-content flex-column" style="margin-top: 100px;">
			@include('nav.home-search')

			<div class="content-wrap">
				<div class="landing-section">
					<div class="title-link">
						<a href="">
							<h3>第 {{ $results->currentPage() }} / {{ $results->lastPage() }} 頁的 {{ $results->total() }} 個搜索結果<span class="title-link-expand pull-right">顯示更多</span></h3>
						</a>
					</div>
					<div class="media-wrap">
						@foreach ($results as $anime)
							@include('home.media-card')
						@endforeach
					</div>
				</div>
			</div>

			<div style="margin-top: -25px" class="search-pagination hidden-xs">{!! $results->appends(request()->query())->onEachSide(1)->links() !!}</div>

			<br>

		</div>
	</div>
</form>
@endsection



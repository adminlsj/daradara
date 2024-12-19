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
						<a href="#">
							<h3>
								第 {{ $results->currentPage() }} / {{ $results->lastPage() }} 頁的 {{ $results->total() }} 個搜索結果
								<div class="title-link-expand pull-right dropdown no-select" style="display: inline-block; padding: 0; margin-top: -2px; position: relative;">
									<button id="search-sort-toggle-btn" class="btn btn-secondary dropdown-toggle no-button-style" type="button" data-toggle="dropdown">
										<img style="width: 8px; margin-top: -2px;" src="https://images2.imgbox.com/78/93/HPOrh13l_o.png" alt="">
										<span style="padding-left: 5px;">{{ $sort ? '依'.$sort.'排序' : '排序'}}</span>
									</button>
									<div id="search-sort-dropdown" class="dropdown-menu">
										<input type="hidden" id="sort" name="sort" value="{{ $sort }}">
										@foreach (['標題', '人氣', '評分', '流行', '讚好', '上傳日期', '上市日期'] as $sort)
											<div class="sort-option">{{ $sort }}</div>
										@endforeach
									</div>
								</div>
							</h3>
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



@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<form id="hentai-form" action="{{ route('staff.search') }}" method="GET">
	<div class="flex-center-wrapper home-wrapper">
		<div class="flex-center-content flex-column" style="margin-top: 100px;">
			<div style="font-size: 2.8rem; color: rgb(100,115,128); font-weight: 800;">搜尋幕後工作人員</div>

			<div class="filters-wrap" style="margin-top: 10px; margin-bottom: 20px;">
				<div class="filters">
					<div class="filter search">
						<h3>搜尋</h3>
						<div class="bar" style="position: relative; width: 344px;">
							<input id="text" name="text" type="text" style="padding-left: 35px;" value="{{ $text ? $text : '' }}">
							<input type="submit" style="display: none">
							<i class="fa fa-search" style="color: rgba(201,215,227); font-size: 1.3rem; height: 1.6rem; position: absolute; left: 12px; top: 12px"></i>
						</div>
					</div>
				</div>
			</div>

			<div class="content-wrap">
				<div class="landing-section">
					<div class="title-link">
						<a href="#">
							<h3>
								第 {{ $results->currentPage() }} / {{ $results->lastPage() }} 頁的 {{ $results->total() }} 個搜索結果
							</h3>
						</a>
					</div>
					<div class="media-wrap">
						@foreach ($results as $staff)
							<div class="media-card">
								<a class="cover" href="{{ route('staff.show', ['staff' => $staff->id, 'title' => $staff->getName($chinese)]) }}">
									<img src="{{ $staff->photo_cover }}" alt="">
								</a>
								<a style="text-decoration: none" href="{{ route('staff.show', ['staff' => $staff->id, 'title' => $staff->getName($chinese)]) }}">{{ $staff->getName($chinese) }}
								</a>
							</div>
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
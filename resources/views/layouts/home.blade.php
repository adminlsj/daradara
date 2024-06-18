@extends('layouts.app')

@section('nav')
	@include('layouts.nav')
@endsection

@section('content')
	<div style="padding: 0 4%">
		<h3>All animes</h1>
		<div class="row">
			@foreach ($animes as $anime)
				<div class="col-md-2">
					<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
						<div style="position: relative;">
							<img style="width: 100%; margin-top: 0;" src="https://images2.imgbox.com/0c/85/A2O2FiGg_o.jpg">
							<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; margin-top: 0;" src="{{ $anime->photo_cover }}">
					    </div>
						<div style="height: 40px">{{ $anime->title_ro }}</div>
					</a>
					<br>
				</div>
			@endforeach
		</div>
		<div class="search-pagination mobile-search-pagination">{{ $animes->links() }}</div>
	</div>
@endsection
@extends('layouts.app')

@section('nav')
	@include('layouts.nav')
@endsection

@section('content')
	<div style="padding: 0 4%">
		<h3>All animes</h1>
		<div class="row">
			@foreach ($animes as $anime)
				<div class="col-md-2" style="height: 100%;">
					<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
						<img style="width: 100%; margin-top: 0px" src="{{ $anime->photo_cover }}">
						<div>{{ $anime->title_ro }}</div>
					</a>
				</div>
			@endforeach
		</div>
		<div class="search-pagination mobile-search-pagination">{{ $animes->links() }}</div>
	</div>
@endsection
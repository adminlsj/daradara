@extends('layouts.app')

@section('nav')
	@include('layouts.nav')
@endsection

@section('content')
	<h3>All animes</h1>
	<div class="row">
		@foreach ($animes as $anime)
			<div class="col-md-1" style="border: 1px solid; height: 150px;">
				<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">{{ $anime->title_ro }}</a>
			</div>
		@endforeach
	</div>
	<div class="search-pagination mobile-search-pagination">{{ $animes->links() }}</div>
@endsection
@extends('layouts.app')

@section('nav')
    @include('layouts.nav')
@endsection

@section('content') 
	<img src="{{ $character->photo_cover }}" alt="{{ $character->name_zht }}">
	<div>{{ $character->name_zht }}</div>

	@foreach ($animes as $anime)
		<img src="{{ $anime->photo_cover }}" alt="{{ $anime->title_zht }}">
		<div>{{ $anime->title_zht }}</div>
	@endforeach
@endsection
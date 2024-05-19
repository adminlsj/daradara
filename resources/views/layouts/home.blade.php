@extends('layouts.app')

@section('nav')
	<a href="/">Home</a>
@endsection

@section('content')
	<div>
		<h3>Top anime</h1>
		<a href="{{ route('anime.show', ['anime' => 1, 'title' => '為美好的世界獻上祝福！']) }}">Konosuba</a>
	</div>
@endsection
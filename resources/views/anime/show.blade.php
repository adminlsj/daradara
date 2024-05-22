@extends('layouts.app')

@section('nav')
	<a href="/">Home</a>
@endsection

@section('content')
    <h3>{{ $anime->title_ch }}</h1>
    <p>{{ $anime->description }}</p>
@endsection
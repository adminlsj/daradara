@extends('layouts.app')

@section('nav')
    @include('layouts.nav')
@endsection

@section('content') 
    @include('layouts.show.banner')
    @include('layouts.show.headings')

    <hr>

    @include('layouts.show.tab')

    <hr>

    @include('layouts.show.overview')
    @include('layouts.show.episodes')
    @include ('layouts.show.characters')
@endsection
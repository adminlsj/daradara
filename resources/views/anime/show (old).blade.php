@extends('layouts.app')

@section('nav')
    @include('layouts.main')
@endsection

@section('content') 
    @include('anime.show.banner')
    @include('anime.show.headings')

    <div class="contents">
        @include('anime.show.sidebar')
        @include('anime.show.overview')
        @include('anime.show.episodes')
        @include('anime.show.characters')
        @include('anime.show.staffs')
        @include('anime.show.comments')
    </div>
@endsection
@extends('layouts.app')

@section('nav')
    @include('layouts.nav')
@endsection

@section('content') 
    @include('anime.show.banner')
    @include('anime.show.headings')

    <div class="contents" style="display: flex; flex-direction: row; padding: 25px 12%; background-color: #0b1622;">
        @include('anime.show.sidebar')
        @include('anime.show.overview')
        @include('anime.show.episodes')
        @include('anime.show.characters')
        @include('anime.show.staffs')
        @include('anime.show.comments')
    </div>
@endsection
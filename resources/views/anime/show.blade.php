@extends('layouts.app')

@section('nav')
    @include('layouts.nav')
@endsection

@section('content') 
    @include('layouts.show.banner')
    @include('layouts.show.headings')

    <div class="contents" style="display: flex; flex-direction: row; padding: 25px 14%; background-color: #0b1622;">
        @include('layouts.show.sidebar')
        @include('layouts.show.overview')
        @include('layouts.show.episodes')
        @include('layouts.show.characters')
        @include('layouts.show.staffs')
        @include('layouts.show.comments')
    </div>
@endsection
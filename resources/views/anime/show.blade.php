@extends('layouts.app')

@section('nav')
    @include('layouts.nav')
@endsection

@section('content') 
    @include('layouts.banner')
    @include('layouts.headings')

    <hr>

    @include('layouts.tab')

    <hr>

    @include('layouts.overview')
@endsection
@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="flex-column user-profile" style="background-color:rgb(237,241,245);">
    @include('user.animelist.show.userProfile')
    <div class="navtabs flex-row">
        <a href="" class="tablinks">簡介</a>
        <a href="" class="tablinks">動畫列表</a>
        <a href="" class="tablinks">喜愛</a>
        <a href="" class="tablinks">討論版</a>
    </div>
    @include('user.animelist.show.animeList')
    @endsection
@extends('layouts.app')

@section('nav')
  @include('nav.comic')
@endsection

@section('content')
@include('ads.comics-banner-exoclick')

<div class="content-padding">
  @foreach ($tags as $key => $value)
    <a class="hover-lighter" href="{{ route('comic.searchTags', ['column' => $column, 'value' => $key]) }}"><div class="no-select" style="background-color: #4d4d4d; border-radius: 5px; color: #d9d9d9; cursor: pointer; display: inline-block; margin-bottom: 4px; padding: 4px 0 4px 7px;"><span style="padding-right: 7px;">{{ $key }}</span><span style="background-color: #333; padding: 6px 6px 6px 6px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; color: grey; font-weight: 400;">{{ $value >= 1000 ? round($value / 1000, 1).'k' : $value }}</span></div></a>
  @endforeach
</div>

@include('ads.comics-banner-juicyads')
@endsection
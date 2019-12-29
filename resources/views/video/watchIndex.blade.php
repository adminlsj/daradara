@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/xSMGFWh.png', 'backgroundColor' => '#222222', 'itemsColor' => "white"])
  @include('layouts.nav-index')
@endsection

@section('content')
  <div class="watch-index">
  	<div style="margin: 0px 10px; padding-top: {{ Request::is('*drama*') || Request::is('*anime*') ? '45px' : '10px' }}" class="row">
  		@foreach ($watches as $watch)
  			<div class="{{ $genre == 'variety' ? 'watch-variety' : 'watch-single' }}">
  		    <a style="text-decoration: none;" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">

            <img class="lazy" style="width: 100%; height: 100%; border-radius: 3px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurM() }}" data-srcset="{{ $watch->imgurM() }}" alt="{{ $watch->title }}">

  			    <div style="height: 34px">
  				    <div style="margin-top: -26px;float: right; margin-right: 3px"><span style="background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px; font-weight: 300">更新至第{{ $watch->videos()->count() }}集</span></div>
  						<h4 style="color:white; margin-top:4px; margin-bottom: 0px; line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-weight: 500;">{{ $watch->title }}</h4>
  					</div>
  				</a>
  			</div>
  		@endforeach
  	</div>
  </div>
@endsection
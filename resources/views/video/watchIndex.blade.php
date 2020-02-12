@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/xSMGFWh.png', 'backgroundColor' => '#222222', 'itemsColor' => "white"])
  @include('layouts.nav-index')
@endsection

@section('content')
  <div class="watch-index">
  	<div style="margin: 0px 5px; padding-top: {{ Request::is('*drama*') || Request::is('*anime*') ? '44px' : '9px' }}" class="row">
  		@foreach ($watches as $watch)
  			<div class="{{ $genre == 'variety' ? 'watch-variety' : 'watch-single' }}">
          <div style="background-color: #222222; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    		    <a style="text-decoration: none;" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">

              <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-top-right-radius: 3px; padding-top: 1px; padding-left: 1px; padding-right: 1px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurM() }}" data-srcset="{{ $watch->imgurM() }}" alt="{{ $watch->title }}">

    			    <div style="height: 47px; padding: 0px 8px;">
    				    <div style="margin-top: -30px;float: right; margin-right: -2px"><span style="background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px; font-weight: 300">更新至第{{ $watch->videos()->count() }}集</span></div>
    						<h4 style="color:white; margin-top:6px; line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-weight: 500;">{{ $watch->title }}</h4>

                <p style=" color: #a9a9a9; margin-top: -6px; margin-bottom: 2px; font-size: 0.8em; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; {{ $genre == 'variety' ? '' : 'display:none;' }}">
                  {{ $watch->cast }}
                </p>
    					</div>
    				</a>
          </div>
  			</div>
  		@endforeach
  	</div>
  </div>
@endsection
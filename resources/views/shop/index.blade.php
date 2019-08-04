@extends('layouts.app')

@section('content')

<div style="margin-top:-20px;" class="div-on-img">
  <a class="active" href="#home">
    <img class="tag img-on-img" src="https://s3.amazonaws.com/twobayjobs/system/intro/current-location.jpg" alt="日本文化">
  </a>
  <img style="z-index: -1" class="img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/cover.jpg" alt="日本文化">
</div>

<div style="margin:0px 10px; height: 200px;border: solid 1px black; margin-top: -25px; background-color: white; border: 0px; border-radius: 5px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); padding: 10px">
  <h4 style="margin: 0px">搜索餐廳</h4>
  <div class="row">
    <div class="col-md-12">
      <input style="width: 100%" type="text" placeholder="Search..">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <input style="width: 100%" type="text" placeholder="Search..">
    </div>
    <div class="col-md-6">
      <input style="width: 100%" type="text" placeholder="Search..">
    </div>
  </div>
</div>

<div style="color: #323232; margin-top: 7px; padding: 10px 15px; font-size: 15px; font-weight: bold; background-color: white; border-top: 1px solid #dbdbdb;">Hot Trending</div>

<div class="row">
	@foreach ($shops as $shop)
		<a href="{{ route('shop.show', ['shop' => $shop]) }}">
		    <div style="border: solid 1px black;" class="col-xs-4">
	        	{{ $shop->name }}
		    </div>
		</a>
	@endforeach
</div>

<br>
@endsection
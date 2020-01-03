@extends('layouts.app')

@section('nav')
	@include('layouts.nav-blog', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray"])
@endsection

@section('content')
	<div class="padding-setup mobile-container">
		<div class="row" style="padding-top: 10px; padding-bottom: 4px">
			@foreach ($blogs as $blog)
				<div class="row hover-box-shadow" style="margin:0px 0px; padding: 15px 15px;">
	                <a href="{{ route('blog.show', ['blog' => $blog]) }}">
	                    <div class="col-xs-4" style="position:relative; padding-right:5px">
	                        <div class="row">
	                            <img style="width:100%; border-radius:2px" src="{{ $blog->imgur() }}" alt="日本文化">
	                            <div class="related-blogs-date" style="font-size: 12.5px; color: gray; position:absolute; bottom:1px; right:-93px; font-weight:400;">{{ Carbon\Carbon::parse($blog->created_at)->format("Y-m-d") }}</div>
	                        </div>
	                    </div>

	                    <div style="padding: 0px 30px 0px 40px" class="col-xs-8">
                            <div class="row">
                                <div class="blog-title">{{ str_limit($blog->title, 95) }}</div>
                                <div class="hidden-xs" style="font-weight: 400; font-size: 13.5px; color: #696969; margin-top:10px">{{ str_limit($blog->caption, 300) }}</div>
                            </div>
                        </div>
	                </a>
	            </div>
			@endforeach
		</div>
	</div>
@endsection
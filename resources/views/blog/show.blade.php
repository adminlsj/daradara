@extends('layouts.app')

@section('content')

<div class="container mobile-container">
	<div class="row">
		<div style="margin-bottom: 15px" class="col-xs-12 col-sm-12 col-md-12 blog-content">
			<img class="img-responsive border-radius-2" style="width:100%;height:100%" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="日本文化">
			
			<div>
				<h4 style="padding-top: 10px; font-weight: 400;">
					<div style="font-size:3rem;">{{ $blog->title }}</div>
					<div style="padding-left: 3px" class="vertical-align">
						<div style="font-size:14px;font-weight:300;">
							{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日') }}
						</div>
						&nbsp;
						<div style="margin-top: -20px;">
							<div class="fb-like" data-href="{{ route('blog.category.show', ['blog' => $blog, 'genre' => App\Blog::$genre_url[$blog->category], 'category' => $blog->category]) }}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
						</div>
					</div>
				</h4>

				@foreach ($content as $cont)
					{!! $cont !!}
				@endforeach

				<div style="margin-top:20px; padding: 10px 5px; width: 100%; background-color: #f0f0f0; text-align: center; color: #3b5998">
					<div style="line-height: 15px">更多日本旅遊資訊及文化，讚好FreeRider專頁</div>
					<div class="fb-like" data-href="https://www.facebook.com/freeriderhk" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div>
		        <h3 style="color: grey; font-weight: 300">{{ App\Blog::$category[$category] }} | {{ App\Blog::$genre[$category] }}資訊</h3>
		        <hr>
		    </div>
			<div class="sidebar-wrapper">
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif" /></div>
			</div>
		</div>
	</div>
</div>
@endsection
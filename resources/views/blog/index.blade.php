@extends('layouts.app')

@section('content')
<div style="margin-top: -20px" class="container mobile-container">
	<div class="row">
		<div style="overflow: hidden" class="blog-carousel owl-carousel owl-theme">
			@foreach ($caro_blogs as $blog)
				<a style="text-decoration: none" href="{{ route('blog.category.show', ['blog' => $blog, 'genre' => App\Blog::$pages[$blog->category]['genre'], 'category' => $blog->category ]) }}">
					<img src="https://s3.amazonaws.com/twobayjobs/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortBy('created_at')->first()->filename }}" alt="日本文化">
					<div style="font-size:17px;color:white;background-color: #333333; padding: 10px; margin: 0px 15px;">
						{{ $blog->title }}
					</div>
				</a>
			@endforeach
		</div>
		
		<div class="col-xs-12 col-sm-12">
			<div>
		        <h3 style="color: grey; font-weight: 300">{{ App\Blog::$pages[$category]['nav'] }}</h3>
		        <hr>
		    </div>
			<div class="sidebar-wrapper">
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif"/></div>
			</div>
		</div>
	</div>
</div>
@endsection
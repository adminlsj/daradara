@extends('layouts.app')

@section('content')
<div style="width:80%" class="container mobile-container">
	<div class="row no-gutter">
		<div class="col-md-8">
			<div style="overflow: hidden;" class="blog-carousel owl-carousel owl-theme">
				@foreach ($caro_blogs as $blog)
					<div class="img-container">
						<a style="text-decoration: none;" href="{{ route('blog.show', ['blog' => $blog, 'genre' => $blog->genre, 'category' => $blog->category ]) }}">
						  <img src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortBy('created_at')->first()->filename }}" alt="Cinque Terre">
						</a>
					</div>
				@endforeach
			</div>
		</div>
		<div class="col-md-4 hidden-xs hidden-sm">
			@foreach ($textBlogs as $blog)
				<div style="margin-right: -16px" class="row no-gutter img-container">
					<a style="text-decoration: none;" href="{{ route('blog.show', ['blog' => $blog, 'genre' => $blog->genre, 'category' => $blog->category ]) }}">
						<div style="margin-bottom: 15px" class="col-md-12">
							<img style="width: 100%" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortBy('created_at')->first()->filename }}" alt="日本文化">
							<div class="img-caption">{{ $blog->title }}</div>
						</div>
					</a>
				</div>
			@endforeach
		</div>
	</div>

	@include('blog.list-blogs')
</div>
@endsection
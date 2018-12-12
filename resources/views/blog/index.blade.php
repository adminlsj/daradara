@extends('layouts.app')

@section('content')
<div class="container mobile-container">
	<div class="row">
		<div class="col-md-12">
			<div class="blog-carousel owl-carousel owl-theme">
				@foreach ($caro_blogs as $blog)
					<a href="{{ route('blog.show', ['blog' => $blog]) }}">
						<img class="embed-responsive-item border-radius-2" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->first()->filename }}" alt="日本文化">
						<div class="center-align white-text" style="position:absolute;bottom:0;left:0;right:0;font-size:17px;color:white;background-color: rgba(0, 0, 0, 0.5);height:70px;padding-left:15px;padding-right:15px; border-radius: 0 0 2px 2px;">
							<span style="line-height: 70px; font-weight: 400; letter-spacing: 1px">{{ $blog->title }}</span>
						</div>
					</a>
				@endforeach
			</div>
		</div>
		
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div>
		        <h3 style="color: grey; font-weight: 300">日本文化與專題</h3>
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
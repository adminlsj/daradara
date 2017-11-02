@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
	<div class="row">
		<div class="col-md-8 col-ms-12">
			<div class="blog-carousel owl-carousel owl-theme">
				@foreach ($caro_blogs as $blog)
					<a href="{{ route('blog.show', ['blog' => $blog->id]) }}">
						<img class="img-responsive border-radius-2" src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->first()->filename }}" alt="First slide">
						<div class="center-align white-text" style="position:absolute;bottom:0;left:0;right:0;font-size:17px;color:white;background-color: rgba(0, 0, 0, 0.5);height:70px;padding-left:15px;padding-right:15px; border-radius: 0 0 2px 2px;">
							<span style="line-height: 70px; font-weight: 300; letter-spacing: 1px">{{ $blog->title }}</span>
						</div>
					</a>
				@endforeach
			</div>

			<div class="row">
				<div class="col-md-12 col-ms-12">
				    <h3 style="color: grey; font-weight: 300">精選貼文</h3>
					<hr>
				</div>
			</div>
			@foreach ($blogs as $blog)
				<div class="col-md-6 col-ms-12">
					<div class="card">
		                <a href="{{ route('blog.show', ['blog' => $blog->id]) }}"><img class="img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="First slide"></a>

					    <div class="card-content">
					        <a style="line-height: 45px; padding: 13px; font-weight: 300; color: grey" href="{{ route('blog.show', ['blog' => $blog->id]) }}">
								{{ $blog->title }}
							</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>
		
		<div class="hide-on-small-only">@include('blog.sidebar')</div>
	</div>

	<script>
		$(document).ready(function(){
			$(".blog-carousel").owlCarousel({
				items: 1,
				autoplay:true,
				autoPlayTimeout: 5000,
				itemsDesktop : [1199,1],
			    itemsDesktopSmall : [979,1],
			    itemsTablet : [768,1],
			    itemsMobile: [479,1],
			    loop: true,
				dots: false,
			    nav: true,
			    navText: [
			      '<i class="material-icons" style="font-size:36px; color:#666666">keyboard_arrow_left</i>',
			      '<i class="material-icons" style="font-size:36px; color:#666666">chevron_right</i>'
			      ]
			});
		});
    </script>
</div>
@endsection
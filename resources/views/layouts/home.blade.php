@extends('layouts.app')

@section('content')
	<div style="position: relative;" class="hidden-xs" style="width: 100%">
		<img style="margin-top: 0px; margin-bottom: 25px; width:100%" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-12.png" alt="Los Angeles">
		@include('job.search-home')
	</div>

	<div class="container" style="width: 85%">
		<div class="row">
			<div class="col-md-8">
				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">Featured Industries</h3>
					<hr>
				</div>
				<div class="row">
					<div class="col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Engineering" type="hidden">
							<button style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-category-01.png" alt="Chicago"></button>
						</form>
					</div>
					<div class="col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Public / Civil" type="hidden">
							<button style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-category-02.png" alt="Chicago"></button>
						</form>
					</div>
					<div class="col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Hospitality / F & B" type="hidden">
							<button style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-category-03.png" alt="Chicago"></button>
						</form>
					</div>
					<div class="col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Sales, CS & Business Devpt" type="hidden">
							<button style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-category-04.png" alt="Chicago"></button>
						</form>
					</div>
				</div>

				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">Browse Jobs</h3>
					<hr>
				</div>
				<div style="padding-top:10px; padding-bottom:10px; margin-left:0px; margin-right: 0px; background-color:#54565c; font-size: 15px; border-radius: 4px" class="row">
					@foreach (App\Job::$category as $key => $element)
						<form id="browse-job-search" action="{{ route('job.search') }}" method="GET">
							<div style="padding-top: 10px;padding-bottom: 10px;" class="col-md-4">
								<input name="category" value="{{ $element }}" type="hidden">
								<button class="browse-job-btn" type="submit">{{ $element }} ({{ App\Job::where('category', $element)->count() }})</button>
							</div>
						</form>
					@endforeach
				</div>

				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">Featured Companies</h3>
					<hr>
				</div>
				<div class="row hidden-xs">
					@foreach ($featuredCompanies as $company)
						<div class="col-md-2">
							<form action="{{ route('job.search') }}" method="GET">
								<input name="title" value="{{ $company }}" type="hidden">
								<button style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category hover-box-shadow d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-company-{{ $company }}.png" alt="Chicago"></button>
							</form>
						</div>
					@endforeach
				</div>

				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">Featured Agencies</h3>
					<hr>
				</div>
				<div class="row hidden-xs">
					@foreach ($featuredAgencies as $agency)
						<div class="col-md-2">
							<form action="{{ route('job.search') }}" method="GET">
								<input name="title" value="{{ $agency }}" type="hidden">
								<button style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category hover-box-shadow d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-company-{{ $agency }}.png" alt="Chicago"></button>
							</form>
						</div>
					@endforeach
				</div>
			</div>

			<div class="col-md-4">
				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">You may be interested in</h3>
					<hr>
				</div>
				<div class="row hidden-xs">
					<div class="col-md-12">
						<img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/commercial-01.jpg" alt="Chicago">
					</div>
				</div>
				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">Let’s explore jobsDB</h3>
					<hr>
				</div>
				<div class="row hidden-xs">
					<div class="col-md-12">
						<img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/commercial-02.png" alt="Chicago">
					</div>
				</div>
				<br>
				<div class="row hidden-xs">
					<div class="col-md-12">
						<img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/commercial-03.png" alt="Chicago">
					</div>
				</div>
			</div>
		</div>

		<div style="margin-top: 40px;">
			<h3 style="color: grey; font-weight: 300">Featured Blogs</h3>
			<hr>
		</div>
		<div class="hidden-xs hidden-sm row">
			<div class="col-md-8 col-ms-12">
				<div class="blog-carousel owl-carousel owl-theme">
					@foreach ($caro_blogs as $blog)
						<a href="{{ route('blog.show', ['blog' => $blog->id]) }}">
							<img class="img-responsive border-radius-2" src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->first()->filename }}" alt="First slide">
							<div class="center-align white-text" style="position:absolute;bottom:0;left:0;right:0;font-size:17px;color:white;background-color: rgba(0, 0, 0, 0.5);height:70px;padding-left:15px;padding-right:15px; border-radius: 0 0 2px 2px;">
								<span style="line-height: 70px; font-weight: 300; letter-spacing: 1px">{{ $blog->title }}</span>
							</div>
						</a>
					@endforeach
				</div>
			</div>
			<div class="col-md-4" style="padding-left: 25px">
				@foreach($relatedBlogs as $blog)
				    <div class="row" style="margin-bottom: 15px;">
				        <div class="col-md-5">
				            <a href="{{ route('blog.show', ['blog' => $blog->id]) }}">
				                <img src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/squares/{{ $blog->id }}/{{ $blog->blogImgs->first()->filename }}" class="img-responsive img-circle">
				            </a>
				        </div>
				        <div class="col-md-7">
				            <div><a href="{{ route('blog.show', ['blog' => $blog->id]) }}"><h3 style="color: black; font-weight: 400; font-size: 15px">{{ str_limit($blog->title, 50) }}</h3></a></div>
				            <div style="font-size: 12.5px">{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日') }}</div>
				        </div>
				    </div>
				@endforeach
				<div class="row" style="margin-top: 25px">
					<div class="col-md-6 col-md-offset-3">
					    <form action="{{ route('blog.index') }}" method="GET">
					        <button type="submit" class="btn btn-info btn-outline btn-lg btn-block" style="border-radius: 0; font-size: 15px;">查看所有貼文</button>
					    </form>
					</div>
				</div>
			</div>
		</div>

		<div class="visible-xs-block visible-sm-block" style="padding-top: 70px">
			<h3 style="color: grey; font-weight: 300">FreeRider部落格</h3>
			<hr>
			@foreach ($similar_blogs as $blog)
				<div class="row" style="margin-bottom: 15px;">
			        <div class="col-md-5 col-xs-5 col-sm-4">
			            <a href="{{ route('blog.show', ['blog' => $blog->id]) }}">
			                <img src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/squares/{{ $blog->id }}/{{ $blog->blogImgs->first()->filename }}" class="img-responsive img-circle">
			            </a>
			        </div>
			        <div class="col-md-7 col-xs-7 col-sm-8">
			            <div><a href="{{ route('blog.show', ['blog' => $blog->id]) }}"><h3 style="color: black; font-weight: 400; font-size: 15px">{{ str_limit($blog->title, 50) }}</h3></a></div>
			            <div style="font-size: 12.5px">{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日') }}</div>
			        </div>
			    </div>
			@endforeach
			<div class="row" style="margin-top: 20px">
				<div class="col-xs-8 col-xs-offset-2">
				    <form action="{{ route('blog.index') }}" method="GET">
				        <button type="submit" class="btn btn-info btn-outline btn-lg btn-block" style="border-radius: 0; font-size: 15px;">查看所有貼文</button>
				    </form>
				</div>
			</div>
		</div>

		<br><br><br><br><br>
	</div>
@endsection
        

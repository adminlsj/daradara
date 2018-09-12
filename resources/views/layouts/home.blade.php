@extends('layouts.app')

@section('content')
	<div class="hidden-xs" style="position: relative;" style="width: 100%">
		<img style="margin-top: 0px; margin-bottom: 25px; width:100%" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-12.png" alt="Los Angeles">
		@include('job.search-home')
	</div>

	<div class="visible-xs-block" style="position: relative;" style="width: 100%">
		<img style="margin-top: 0px; margin-bottom: 25px; width:100%" src="https://s3.amazonaws.com/twobayjobs/system/intro/mobile-poster.png" alt="Los Angeles">
		@include('job.mobile.search-home')
	</div>

	<div class="container" style="width: 85%">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">Featured Industries</h3>
					<hr>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="E-commerce" type="hidden">
							<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-e-commerce-01.png" alt="Chicago"></button>
						</form>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Information Technology" type="hidden">
							<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-information-technology-03.png" alt="Chicago"></button>
						</form>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Marketing / Media" type="hidden">
							<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-marketing-media-02.png" alt="Chicago"></button>
						</form>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Merchandising / Logistics" type="hidden">
							<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-merchandising-logistics-01.png" alt="Chicago"></button>
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
								<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-company-{{ $company }}.png" alt="Chicago"></button>
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
								<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-company-{{ $agency }}.png" alt="Chicago"></button>
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
					<h3 style="color: grey; font-weight: 300">Industry Average Salaries</h3>
					<hr>
				</div>
				@foreach (App\Job::$category as $key => $element)
					<div class="col-md-12">
						<a href="/jobs/search?category={{ $element }}">
							<div style="padding:10px; border-radius: 5px; border: solid 1px #f2f2f2; margin-bottom: 15px;" class="row hover-box-shadow">
								<div style="font-weight:600; text-align: center" class="col-md-12">
									<span class="pull-left">{{ $loop->index + 1 }}.</span>
									<span class="pull-center">{{ $element }}</span>
									<span class="pull-right">RMB ¥{{ round(App\Job::where('category', $element)->avg('salary')) }}</span>
								</div>
							</div>
						</a>
					</div>
				@endforeach
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
			<div class="col-md-4 related-blogs" style="padding-left: 25px; padding-right: 30px">
				@foreach($relatedBlogs as $blog)
					@include('blog.related-blogs')
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

		<br><br><br><br><br>
	</div>
@endsection
        

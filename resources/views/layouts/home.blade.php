@extends('layouts.app')

@section('content')
	<div class="hidden-xs" style="position: relative;" style="width: 100%">
		<img style="margin-top: 0px; margin-bottom: 25px; width:100%" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-banner.png" alt="Los Angeles">
		@include('job.search-home')
	</div>

	<div class="visible-xs-block" style="position: relative;" style="width: 100%">
		<img style="margin-top: 0px; margin-bottom: 25px; width:100%" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-banner-mobile.png" alt="Los Angeles">
		@include('job.mobile.search-home')
	</div>

	<div class="container" style="width: 90%">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">最受矚目的行業</h3>
					<hr>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="E-commerce" type="hidden">
							<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-industry-電子商務.png" alt="Chicago"></button>
						</form>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Information Technology" type="hidden">
							<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-industry-互聯網.png" alt="Chicago"></button>
						</form>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Marketing / Media" type="hidden">
							<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-industry-市場.png" alt="Chicago"></button>
						</form>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
							<input name="category" value="Merchandising / Logistics" type="hidden">
							<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-industry-物流.png" alt="Chicago"></button>
						</form>
					</div>
				</div>

				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">瀏覽所有行業</h3>
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
					<h3 style="color: grey; font-weight: 300">最受矚目的公司</h3>
					<hr>
				</div>
				<div class="row">
					@foreach ($featuredCompanies as $company)
						<div class="col-xs-4 col-sm-4 col-md-2">
							<form action="{{ route('job.search') }}" method="GET">
								<input name="title" value="{{ $company }}" type="hidden">
								<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-company-{{ $company }}.png" alt="Chicago"></button>
							</form>
							@if ($loop->index == 0 || $loop->index == 1 || $loop->index == 2)
								<div class="visible-xs-block visible-sm-block" style="margin-bottom: 10px;"></div>
							@endif
						</div>
					@endforeach
				</div>

				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">已認證的獵頭公司</h3>
					<hr>
				</div>
				<div class="row">
					@foreach ($featuredAgencies as $agency)
						<div class="col-xs-4 col-sm-4 col-md-2">
							<form action="{{ route('job.search') }}" method="GET">
								<input name="title" value="{{ $agency }}" type="hidden">
								<button class="btn-undecorate hover-box-shadow" style="width:100%; padding:0px; border:0px;" type="submit"><img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-company-{{ $agency }}.png" alt="Chicago"></button>
							</form>
						</div>
					@endforeach
				</div>

				@include('blog.index-main')
			</div>

			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="hidden-xs hidden-sm" style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">為您推薦的內容</h3>
					<hr>
				</div>
				<div class="hidden-xs hidden-sm row">
					<div class="col-sm-12 col-md-12">
						<img class="featured-category d-block img-responsive" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-side.png" alt="Chicago">
					</div>
				</div>
				<div class="hidden-xs hidden-sm" style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">行業平均薪資</h3>
					<hr>
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
							@if ($loop->last)
								<br style="margin-bottom:40px;">
							@endif
						</div>
					@endforeach
				</div>

				<div style="margin-top: 40px;">
					<h3 style="color: grey; font-weight: 300">兩岸生活資訊</h3>
					<hr>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 related-blogs">
					@foreach($relatedBlogs as $blog)
						@include('blog.related-blogs')
					@endforeach
					<div class="row" style="margin-top: 25px">
						<div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
						    <form action="{{ route('blog.index') }}" method="GET">
						        <button type="submit" class="btn btn-info btn-outline btn-lg btn-block" style="border-radius: 0; font-size: 15px;">查看所有貼文</button>
						    </form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<br><br><br><br><br>
	</div>
@endsection
        

@extends('layouts.app')

@section('content')
<div class="container mobile-container">
	<div class="row">
		<div class="col-md-8 col-ms-12 blog-content">
			<div style="background-color: #f0f0f0; margin-bottom: 20px">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- Content -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:auto;height:100px"
				     data-ad-client="ca-pub-4485968980278243"
				     data-ad-slot="9914751067"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>

			<img class="img-responsive border-radius-2" style="width:100%;height:100%" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="日本旅行推薦">
			
			<div class="">
				<h4 style="padding-top: 10px; padding-bottom: 20px; font-weight: 400;">
					{{ $blog->title }}
					<span class="pull-right" style="font-size:14px;font-weight:300">
						<div style="margin-bottom:-25px">{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日') }}</div>
					</span>
				</h4>

				@foreach ($content as $cont)
					{!! $cont !!}
				@endforeach

				<div style="word-wrap: break-word !important; margin-top: 15px;" class="fb-like" data-href="https://www.facebook.com/freeriderhk/" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
			</div>

			<div style="background-color: #f0f0f0; margin: 25px 0px 70px 0px;" class="container visible-xs-block visible-sm-block">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Content -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="9914751067"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
			</div>

			<div class="row hidden-xs hidden-sm">
				<div class=" hidden-xs hidden-sm col-md-12">
				    <h3 style="color: grey; font-weight: 300">為您推薦的貼文</h3>
					<hr>
				</div>

				@foreach ($similar_blogs as $blog)
					<div class="col-md-6 col-ms-12">
						<div class="card">
			                <a href="{{ route('blog.show', ['blog' => $blog->id]) }}"><img class="img-responsive" src="https://s3.amazonaws.com/twobayjobs/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="日本旅行推薦"></a>

						    <div class="card-content">
						        <a style="line-height: 25px; padding: 13px; font-weight: 300; color: grey; display:block; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" href="{{ route('blog.show', ['blog' => $blog->id]) }}">
									{{ $blog->title }}
								</a>
							</div>
						</div>
					</div>
				@endforeach
				<br><br><br>
			</div>
		</div>
			
		<div class="hidden-xs hidden-sm col-md-4" style="padding-left: 25px">
			@include('blog.sidebar')
		</div>

		<div style="margin-top: -40px" class="visible-xs-block visible-sm-block col-sm-12">
			@include('blog.sidebar')
		</div>

	</div>
</div>
@endsection
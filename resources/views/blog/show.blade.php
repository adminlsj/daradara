@extends('layouts.app')

@section('content')
<div class="container mobile-container">
	<div class="row">
		<div style="margin-bottom: 15px" class="col-xs-12 col-sm-12 col-md-8 blog-content">
			<div style="margin-bottom: 10px">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- Content -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:100%;height:100px"
				     data-ad-client="ca-pub-4485968980278243"
				     data-ad-slot="9914751067"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>

			<img class="img-responsive border-radius-2" style="width:100%;height:100%" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="日本文化">
			
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

			<div style="margin-top: 20px;" class="row hidden-xs hidden-sm">
				<div class="col-md-12">
				    <h3 style="color: grey; font-weight: 300">為您推薦的貼文</h3>
					<hr>
				</div>

				@foreach ($similar_blogs as $blog)
					<div class="col-md-6 col-ms-12">
						<div class="card">
			                <a href="{{ route('blog.show', ['blog' => $blog->id]) }}"><img class="img-responsive" src="https://s3.amazonaws.com/twobayjobs/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="日本文化"></a>

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

		<div class="col-xs-12 col-sm-12 col-md-4 sidebar-sm">
			@include('blog.sidebar')
		</div>

	</div>
</div>
@endsection
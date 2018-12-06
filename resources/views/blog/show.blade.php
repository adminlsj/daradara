@extends('layouts.app')

@section('content')

<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v3.2&appId=204935246651575&autoLogAppEvents=1';
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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
			
			<div>
				<h4 style="padding-top: 10px; padding-bottom: 10px; font-weight: 400;">
					<div>{{ $blog->title }}</div>
					<div style="padding-left: 3px" class="vertical-align">
						<div style="font-size:14px;font-weight:300;">
							{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日') }}
						</div>
						&nbsp;
						<div style="margin-top: -20px;">
							<div class="fb-like" data-href="https://www.facebook.com/freeriderhk" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
						</div>
					</div>
				</h4>

				@foreach ($content as $cont)
					{!! $cont !!}
				@endforeach
			</div>

			<div style="margin-top: 20px;" class="row hidden-xs hidden-sm">
				<div class="col-md-12">
				    <h3 style="color: grey; font-weight: 300">為您推薦的貼文</h3>
					<hr>
				</div>

				@foreach ($similar_blogs as $blog)
					<div class="col-md-6 col-ms-12">
						<div class="card">
			                <a href="{{ route('blog.show', ['blog' => $blog]) }}"><img class="img-responsive" src="https://s3.amazonaws.com/twobayjobs/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="日本文化"></a>

						    <div class="card-content">
						        <a style="line-height: 25px; padding: 13px; font-weight: 300; color: grey; display:block; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" href="{{ route('blog.show', ['blog' => $blog]) }}">
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
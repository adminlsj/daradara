@extends('layouts.app')

@section('content')

<div style="width: 80%" class="container mobile-container">
	<div class="row no-gutter">
		<div class="col-md-8">
			<div style="margin-bottom: 15px" class="blog-content">
				<img class="img-responsive border-radius-2" style="width:100%;height:100%" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="日本文化">
				
				<div>
					<h4 style="padding-top: 10px; font-weight: 400;">
						<div style="font-size:3rem;">{{ $blog->title }}</div>
						<div style="padding-left: 3px" class="vertical-align">
							<div style="font-size:14px;font-weight:300;">
								{{ Carbon\Carbon::parse($blog->created_at)->format('d / m / Y') }}
							</div>
							&nbsp;
							<div style="margin-top: -20px;">
								<div class="fb-like" data-href="https://www.freeriderhk.com/freeriderjapan/{{ $blog->category }}/{{ $blog->id }}/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
							</div>
						</div>
					</h4>

					@foreach ($content as $cont)
						{!! $cont !!}
					@endforeach

					<div style="margin-top:20px; padding: 10px 5px; width: 100%; background-color: #f0f0f0; text-align: center; color: #3b5998">
						<div style="line-height: 15px">更多專業知識與分析，讚好FreeRider專頁</div>
						<div class="fb-like" data-href="https://www.facebook.com/freeriderjapan" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
					</div>
				</div>
			</div>
		</div>

		<div style="padding-left: 20px" class="hidden-xs hidden-sm col-md-4 sticky">
			<div>
		        <h3 style="color: black; font-weight: 500; margin-bottom: 17px;">相關主題</h3>
		    </div>
		    @foreach ($sideBlogsDesktop as $blog)
				<div style="border-left: black 3px solid; margin-left: 0px" class="row">
		            <a href="{{ route('blog.show', ['blog' => $blog, 'genre' => $blog->genre, 'category' => $blog->category ]) }}">
		                <div class="col-md-12">
		                    <div style="font-weight: 400; font-size: 15px; color: black">{{str_limit($blog->title, 80)}}</div>
		                    <div style="font-size: 12.5px; color: #D3D3D3; margin-top: 10px;">{{ Carbon\Carbon::parse($blog->created_at)->format("Y年m月d日") }}</div>
		                </div>
		            </a>
		        </div>
		        <br>
		    @endforeach
		    <div style="margin:5px 0px 15px 0px; border: 1px black solid">
	            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	            <!-- Content-Top -->
	            <ins class="adsbygoogle"
	                 style="display:block"
	                 data-ad-client="ca-pub-4485968980278243"
	                 data-ad-slot="4060710969"
	                 data-ad-format="auto"
	                 data-full-width-responsive="true"></ins>
	            <script>
	            (adsbygoogle = window.adsbygoogle || []).push({});
	            </script>
	        </div>
	    </div>
	</div>

	@include('blog.list-blogs')
</div>
@endsection
@extends('layouts.app')

@section('head')
    @parent
    <meta property="og:url" content="{{ route('blog.show', ['blog' => $current]) }}" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="{{ $current->title }}" />
	<meta property="og:description" content="{{ $current->caption }}" />
	<meta property="og:image" content="https://i.imgur.com/{{ $current->imgur }}.jpg" />

	<meta name="title" content="{{ $current->title }} | 娛見日本 LaughSeeJapan">
	<title>{{ $current->title }} | 娛見日本 LaughSeeJapan</title>
	<meta name="description" content="{{ $current->caption }}">
@endsection

@section('nav')
	@include('layouts.nav-blog', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray"])
@endsection

@section('content')

<div class="padding-setup mobile-container">
	<div class="row no-gutter">
		<div class="col-md-8">
			<div style="margin-bottom: 15px" class="blog-content">
				<img class="img-responsive border-radius-2" style="width:100%;height:100%" src="{{ $blog->imgur() }}" alt="日本文化">
				
				<div>
					<h4 style="padding-top: 10px; font-weight: 400;">
						<div class="blog-show-title">{{ $blog->title }}</div>
						<div style="padding-left: 3px" class="vertical-align">
							<div style="font-size:14px;font-weight:300;">
								{{ Carbon\Carbon::parse($blog->created_at)->format('d / m / Y') }}
							</div>
						</div>
					</h4>

					@foreach ($content as $cont)
						{!! $cont !!}
					@endforeach

					<div style="margin-top:20px; padding: 10px 5px; width: 100%; background-color: #f0f0f0; text-align: center; color: #3b5998">
						<div style="line-height: 15px">更多日本旅遊與文化，讚好<a style="color: #3b5998; text-decoration: underline;" href="https://www.facebook.com/freeriderjapan" target="_blank">FreeRider專頁</a></div>
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
		            <a href="{{ route('blog.show', ['blog' => $blog]) }}">
		                <div class="col-md-12">
		                    <div style="font-weight: 400; font-size: 15px; color: black">{{str_limit($blog->title, 80)}}</div>
		                    <div style="font-size: 12.5px; color: #D3D3D3; margin-top: 10px;">{{ Carbon\Carbon::parse($blog->created_at)->format("Y年m月d日") }}</div>
		                </div>
		            </a>
		        </div>
		        <br>
		    @endforeach
		    <div style="margin:5px 0px 15px 0px; border: 1px black solid">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Blog Show Ads -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="6532428575"
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
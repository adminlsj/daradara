<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-78314014-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-78314014-1');
    </script>

    <!-- Google Adsense -->
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-4485968980278243",
        enable_page_level_ads: true
      });
    </script>

    <meta property="og:url" content="{{ route('blog.show', ['blog' => $blog->id]) }}" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="{{ $blog->title }}" />
	<meta property="og:description" content="{{ str_limit($fb_title, 50) }}" />
	<meta property="og:image" content="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->first()->filename }}" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- File Uploads -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.4/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.4/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.4/js/plugins/purify.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.4/js/locales/LANG.js"></script>

</head>
<body>
    <div id="app">
        <div style="margin-bottom: 60px">@include('layouts.nav')</div>
		<div class="container" style="width:90%;">
			<div class="row">
				<div style="margin-top:40px; " class="col-md-8 col-ms-12 blog-content">
					<img class="img-responsive border-radius-2" style="width:100%;height:100%" src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="First slide">
					
					<div class="">
						<h4 style="padding-top: 10px; padding-bottom: 20px">
							{{ $blog->title }}
							<span class="pull-right" style="font-size:15px;font-weight:300">
								<div style="margin-bottom:-25px">{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日') }}</div>
							</span>
						</h4>

						@foreach ($content as $cont)
							{!! $cont !!}
						@endforeach
						<br>
						<div class="right"><iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Ffreeriderhk%2F&width=450&layout=standard&action=like&show_faces=true&share=true&height=80&appId" width="260" height="80" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>
					</div>

					<br>

					<div class="row">
						<div class="col-md-12 col-ms-12">
						    <h3 style="color: grey; font-weight: 300">為您推薦的貼文</h3>
							<hr>
						</div>
					</div>
					<div class="row">
						<div class="hidden-xs">
							@foreach ($similar_blogs as $blog)
								<div class="col-md-6 col-ms-12">
									<div class="card">
						                <a href="{{ route('blog.show', ['blog' => $blog->id]) }}"><img class="img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="First slide"></a>

									    <div class="card-content">
									        <a style="line-height: 25px; padding: 13px; font-weight: 300; color: grey; display:block; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" href="{{ route('blog.show', ['blog' => $blog->id]) }}">
												{{ $blog->title }}
											</a>
										</div>
									</div>
								</div>
							@endforeach
						</div>
						<div class="visible-xs-block" style="padding-bottom: 10px">
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
						</div>
					</div>
					<br><br><br>
				</div>
					
				<div class="col-md-4" style="padding-left: 25px">
					@include('blog.sidebar')
				</div>
			</div>
		</div>
		@include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
</body>
</html>

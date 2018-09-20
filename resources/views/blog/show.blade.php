<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125786247-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-125786247-1');
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
	<meta property="og:image" content="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- File Uploads -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.4/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.4/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.4/js/plugins/purify.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.4/js/locales/LANG.js"></script>

    <link rel="shortcut icon" type="image/x-icon" href="https://s3.amazonaws.com/twobayjobs/system/intro/browser-icon.ico"/>
</head>
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = 'https://connect.facebook.net/zh_HK/sdk.js#xfbml=1&version=v3.1';
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

    <div id="app">
        <div style="margin-bottom: 60px">@include('layouts.nav')</div>
		<div class="container" style="width:90%;">
			<div class="row">
				<div style="margin-top:40px; " class="col-md-8 col-ms-12 blog-content">
					<img class="img-responsive border-radius-2" style="width:100%;height:100%" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="First slide">
					
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
						<div class="fb-like" data-href="https://www.facebook.com/twobayjobs/" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
					</div>

					<br>

					<div class="visible-xs-block visible-sm-block">
						<a href="/"><img style="width:100%; border: solid 1px #f2f2f2; border-radius: 3px" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-side.png" alt="Los Angeles"></a>
						<br><br>
					</div>

					<div class="row hidden-xs hidden-sm">
						<div class=" hidden-xs hidden-sm col-md-12">
						    <h3 style="color: grey; font-weight: 300">為您推薦的貼文</h3>
							<hr>
						</div>

						@foreach ($similar_blogs as $blog)
							<div class="col-md-6 col-ms-12">
								<div class="card">
					                <a href="{{ route('blog.show', ['blog' => $blog->id]) }}"><img class="img-responsive" src="https://s3.amazonaws.com/twobayjobs/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="First slide"></a>

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

				<div style="margin-top: -30px" class="visible-xs-block visible-sm-block col-sm-12">
					@include('blog.sidebar')
				</div>

			</div>
		</div>
		@include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

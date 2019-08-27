<!DOCTYPE HTML>
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

    @if (Request::is('*/*/*'))
        <meta property="og:url" content="{{ route('blog.show', ['blog' => $current_blog, 'genre' => $current_blog->genre, 'category' => $current_blog->category]) }}" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ $current_blog->title }}" />
        <meta property="og:description" content="{{ $current_blog->caption }}" />
        <meta property="og:image" content="https://twobayjobs.s3.amazonaws.com/blogImgs/originals/{{ $current_blog->id }}/{{ $current_blog->blogImgs->sortby('created_at')->first()->filename }}" />

        <meta name="title" content="{{ $current_blog->title }} | {{ App\Blog::$genres[$current_blog->genre]['navTitle'] }} | FreeRider">
        <title>{{ $current_blog->title }} | {{ App\Blog::$genres[$current_blog->genre]['navTitle'] }} | {{ array_search($video->category, App\Blog::$genres[$video->genre]['categories']) }})</title>
        <meta name="description" content="{{ str_limit($fb_title, 150) }}">
    @else
        <meta name="description" 
              content="FreeRider自由旅行人，撰寫相關日本文化的趣味性和探討性專題，並且分享最新的日本文化資訊。從日本歷史的古蹟與文化，到現代的科技與藝術，從庶民的生活與百態，到天皇的皇居與城府，FreeRider是專屬於喜愛日本文化群眾的頭條新聞。">
    @endif

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="gNa13GHr2gcHfxADuqMpBcL2XwEVTF1INmpmxir2fxY" />
    <link rel="shortcut icon" type="image/x-icon" href="https://s3.amazonaws.com/twobayjobs/system/intro/browser-icon.ico"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v4.0"></script>
    
    <div id="app">
        <div style="margin-bottom: 10px; box-shadow: 0 2px 2px -2px rgba(0,0,0,.2);">@include('layouts.nav')</div>
        <div style="margin-top: 50px;" class="responsive-frame">
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

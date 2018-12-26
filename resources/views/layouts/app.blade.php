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
        <meta property="og:url" content="{{ route('blog.category.show', ['blog' => $current_blog, 'genre' => App\Blog::$pages[$current_blog->category]['genre'], 'category' => $current_blog->category]) }}" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ $current_blog->title }}" />
        <meta property="og:description" content="{{ str_limit($fb_title, 50) }}" />
        <meta property="og:image" content="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $current_blog->id }}/{{ $current_blog->blogImgs->sortby('created_at')->first()->filename }}" />

        <meta name="title" content="{{ $current_blog->title }} | {{ App\Blog::$pages[$current_blog->category]['nav'] }} | FreeRider">
        <title>{{ $current_blog->title }} | {{ App\Blog::$pages[$current_blog->category]['nav'] }} | FreeRider</title>
        <meta name="description" content="{{ str_limit($fb_title, 150) }}">
    @else
        <meta name="title" content="{{ App\Blog::$pages[$category]['nav'] }} | FreeRider">
        <title>{{ App\Blog::$pages[$category]['nav'] }} | FreeRider</title>
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
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/{{ $category == 'japanews' ? 'en_US' : 'zh_TW' }}/sdk.js#xfbml=1&version=v3.2&appId=204935246651575&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
    <div id="app">
        <div style="margin-bottom: 10px">@include('layouts.nav')</div>
        @yield('content')
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

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
        <meta name="title" content="日娛王道 | 日本最強娛樂 | 日本最新綜藝">
        <title>日娛王道 | 日本最強娛樂 | 日本最新綜藝</title>
        <meta name="description" 
              content="日本最強娛樂，最新綜藝！從娛樂圈到綜藝圈，娛見日本包攬最新最全的日娛王道！從搞笑到感動，從笑梗到溫情，從寵物到家庭，這裡可以找到讓你大笑，讓你痛哭，讓你重拾失去的情感，讓你回歸最原始的自己！這裡是日本，最強娛樂，最新綜藝，以及人文與文化！">
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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    
    <div id="app">
        <div>@include('layouts.nav')</div>
        <div style="margin-top: 60px;" class="responsive-frame">
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

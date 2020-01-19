<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    @section('head')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="gNa13GHr2gcHfxADuqMpBcL2XwEVTF1INmpmxir2fxY" />
        <link rel="shortcut icon" type="image/x-icon" href="https://s3.amazonaws.com/twobayjobs/system/intro/browser-icon.ico"/>
        <link rel="apple-touch-icon" href="https://i.imgur.com/OCEaQMK.png"/>
        <link rel="canonical" href="https://www.laughseejapan.com{{ Request::getRequestUri() }}" />
        @if (Request::is('*trending*'))
            <meta name="robots" content="noindex, follow" />
        @endif
    @show

    <meta name="title" content="娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫">
    <title>娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫</title>
    <meta name="description" 
          content="日本最強娛樂，最新綜藝！從綜藝到日劇和動漫，娛見日本 LaughSeeJapan 包攬最新最全的日娛王道！從搞笑到感動，從笑梗到溫情，從寵物到家庭，這裡可以找到讓你大笑，讓你痛哭，讓你重拾失去的情感，讓你回歸最原始的自己！這裡是日本，最強娛樂，最新綜藝，以及人文與文化！">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div style="background-color:{{ !Request::is('/') && !Request::is('*rank*') && !Request::is('*search*') && $is_program ? '#414141' : 'white' }};">

        @yield('nav')

        <div style="margin-top: 50px;" class="responsive-frame">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div id="error" style="color: white; width: 100%; background-color: #d84b6b; text-align: center; padding: 10px;">感謝您向我們提供意見，我們會儘快修正任何錯誤。</div>
                @endforeach
            @endif
            @yield('content')
        </div>

        @include('layouts.footer')
    </div>

    <!-- CSS Styles Deferred -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    @section('script')
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>

        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125786247-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-125786247-1');
        </script>
    @show
</body>
</html>

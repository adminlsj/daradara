<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    @section('head')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="referrer" content="no-referrer">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="google-site-verification" content="oV77KljbCxlciy-aD-Uy_dZSYUENVR_6jAhWSp_cb48" />
        <meta name="exoclick-site-verification" content="c02975e2897725fd5f30045bf364309a">
        <meta name="juicyads-site-verification" content="cc330848f3dfc20e8259699c6a096411">
        <link rel="shortcut icon" type="image/x-icon" href="https://i.imgur.com/PTFz5Ej.png"/>
        <link rel="apple-touch-icon" href="https://i.imgur.com/PTFz5Ej.png"/>
        <link rel="canonical" href="https://hanime1.me{{ Request::getRequestUri() }}" />
        <meta name="RATING" content="RTA-5042-1996-1400-1577-RTA" />
    @show

    <meta name="title" content="Hanime1.me - H動漫/裏番/線上看">
    <title>Hanime1.me - H動漫/裏番/線上看</title>
    <meta name="description" 
          content="Hanime1.me 帶給你最完美的H動漫、H動畫、裏番、里番、成人工口的線上看體驗，絕對沒有天殺的片頭廣告！">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Sharp" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
    <div style="{{ Request::is('*comic*') ? 'background-color: #0d0d0d;' : '' }}">
        @yield('nav')

        <div style="overflow-x: hidden;">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div id="error" style="color: white; width: 100%; background-color: #d84b6b; text-align: center; position: fixed; top: 0; z-index: 10001">{{ $error }}</div>
                @endforeach
            @endif

            <script async type="application/javascript" src="https://a.realsrv.com/ad-provider.js"></script>
            @yield('content')
            <script>(AdProvider = window.AdProvider || []).push({'serve': {}});</script>

            @include('layouts.footer')
        </div>

        <!-- The actual snackbar -->
        <div id="snackbar">Some text some message..</div>
    </div>

    <!-- CSS Styles Deferred -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    @section('script')
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125786247-2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-125786247-2');
        </script>

        <!-- Google Adsense -->
        <script data-ad-client="ca-pub-4485968980278243" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

        <script data-cfasync="false" type="text/javascript">(function(s,o,l,v,e,d){if(s[o]==null&&s[l+e]){s[o]="loading";s[l+e](d,l=function(){s[o]="complete";s[v+e](d,l,!1)},!1)}})(document,"readyState","add","remove","EventListener","DOMContentLoaded");(function(){var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="https://cdn.impactserving.com/Scripts/infinity.js.aspx?guid=75b4ac7f-9a66-41df-8b31-822964ff008b";s.id="infinity";s.setAttribute("data-guid","75b4ac7f-9a66-41df-8b31-822964ff008b");s.setAttribute("data-version","async");var e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(s,e)})();</script>
    @show
</body>
</html>

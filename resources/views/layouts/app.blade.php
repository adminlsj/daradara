<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    @section('head')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="referrer" content="origin">
        <meta name="viewport" content="width=device-width, height=device-height">
        <meta name="google-site-verification" content="oV77KljbCxlciy-aD-Uy_dZSYUENVR_6jAhWSp_cb48" />
        <meta name="exoclick-site-verification" content="c02975e2897725fd5f30045bf364309a">
        <meta name="juicyads-site-verification" content="cc330848f3dfc20e8259699c6a096411">
        <link rel="shortcut icon" type="image/x-icon" href="https://vdownload.hembed.com/image/icon/tab_logo.png?secure=EJYLwnrDlidVi_wFp3DaGw==,4867726124"/>
        <link rel="apple-touch-icon" href="https://vdownload.hembed.com/image/icon/tab_logo.png?secure=EJYLwnrDlidVi_wFp3DaGw==,4867726124"/>
        <link rel="canonical" href="https://swiftshare.me{{ Request::getRequestUri() }}" />
    @show

    <meta name="title" content="SwiftShare.me - Share in a Swift.">
    <title>SwiftShare.me - Share in a Swift.</title>
    <meta name="description" 
          content="Upload, Store, Download. All in a Swift.">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Sharp" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css2?family=Encode+Sans+Condensed:wght@700&display=swap' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</head>
<body style="overflow: hidden;">
    @yield('nav')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="error" style="color: white; width: 100%; background-color: #d84b6b; text-align: center; position: fixed; top: 0; z-index: 10001">{{ $error }}</div>
        @endforeach
    @endif

    @yield('content')

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

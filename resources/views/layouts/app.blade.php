<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
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

    @if (Request::has('v') && Request::get('v') != 'null')
        <meta property="og:url" content="{{ route('video.watch') }}?v={{ $current->id }}" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ $current->title }}" />
        <meta property="og:description" content="{{ $current->caption }}" />
        <meta property="og:image" content="https://i.imgur.com/{{ $current->imgur }}h.png" />

        <meta name="title" content="{{ $current->title }} | 娛見日本 LaughSeeJapan">
        <title>{{ $current->title }} | 娛見日本</title>
        <meta name="description" content="{{ $current->caption }}">

        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "VideoObject",
          "name": "{{ $current->title }}",
          "description": "{{ $current->caption }}",
          "thumbnailUrl": [
            "https://i.imgur.com/{{ $current->imgur }}l.png"
           ],
          "uploadDate": "{{ \Carbon\Carbon::parse($current->created_at)->format('Y-m-d\Th:i:s').'+00:00' }}",
          "duration": "{{ $current->durationData() }}",
          @if ($current->outsource)
              "embedUrl": "{{ $current->sd }}",
          @else
              "contentUrl": "{{ $current->sd }}",
          @endif
          "interactionStatistic": {
            "@type": "InteractionCounter",
            "interactionType": { "@type": "http://schema.org/WatchAction" },
            "userInteractionCount": {{ $current->views }}
          }
        }
        </script>

    @elseif (Request::has('query') && Request::get('query') != 'null')
        <meta name="title" content="{{ Request::get('query') }} | 娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫">
        <title>{{ Request::get('query') }} | 娛見日本 LaughSeeJapan</title>

    @elseif (Request::is('*anime/*'))
        <meta name="title" content="{{ $watch->title }} | 娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫">
        <title>{{ $watch->title }} | 娛見日本 LaughSeeJapan</title>

    @else
        <meta name="title" content="娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫">
        <title>娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫</title>
        <meta name="description" 
              content="日本最強娛樂，最新綜藝！從綜藝到日劇和動漫，娛見日本 LaughSeeJapan 包攬最新最全的日娛王道！從搞笑到感動，從笑梗到溫情，從寵物到家庭，這裡可以找到讓你大笑，讓你痛哭，讓你重拾失去的情感，讓你回歸最原始的自己！這裡是日本，最強娛樂，最新綜藝，以及人文與文化！">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
    <div style="background-color:{{ !Request::is('/') && !Request::is('*rank*') && !Request::is('*search*') && $is_program ? '#414141' : 'white' }};">
        <div>@include('layouts.nav')</div>
        <div style="margin-top: 50px;" class="responsive-frame">
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>

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

    <!-- Google Adsense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({
              google_ad_client: "ca-pub-4485968980278243",
              enable_page_level_ads: true
         });
    </script>

    <!-- Alexa Certify Javascript -->
    <script type="text/javascript">
    _atrk_opts = { atrk_acct:"4w4+t1FYxz20cv", domain:"laughseejapan.com",dynamic: true};
    (function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://certify-js.alexametrics.com/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
    </script>
    <noscript><img src="https://certify.alexametrics.com/atrk.gif?account=4w4+t1FYxz20cv" style="display:none" height="1" width="1" alt="" /></noscript>
</body>
</html>

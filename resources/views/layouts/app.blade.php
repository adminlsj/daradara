<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    @section('head')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="referrer" content="no-referrer">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="google-site-verification" content="oV77KljbCxlciy-aD-Uy_dZSYUENVR_6jAhWSp_cb48" />
        <meta name="trafficjunky-site-verification" content="x35a1zw58" />
        <meta name="trafficjunky-custom-phrase" content="sloths love apples" />
        <link rel="shortcut icon" type="image/x-icon" href="https://s3.amazonaws.com/twobayjobs/system/intro/browser-icon.ico"/>
        <link rel="apple-touch-icon" href="https://i.imgur.com/OCEaQMK.png"/>
        <link rel="canonical" href="https://www.laughseejapan.com{{ Request::getRequestUri() }}" />
        @if (Request::is('*trending*') || Request::is('*userReport*'))
            <meta name="robots" content="noindex, follow" />
        @endif
    @show

    <meta name="title" content="娛見日本 LaughSeeJapan">
    <title>娛見日本 LaughSeeJapan</title>
    <meta name="description" 
          content="在娛見日本 LaughSeeJapan 上享受您最愛的影片、崁入原創內容，並與全世界觀眾分享您的影片。">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div>
        @yield('nav')

        <div id="{{ Request::is('*search*') || Request::is('/') || Request::is('*hentai*') || Request::is('*watch*') ? '' : 'content-div'}}" style="{{ Request::is('/') || Request::is('*database/*') ? '' : 'margin-top: 50px;'}} overflow-x: hidden;">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div id="error" style="color: white; width: 100%; background-color: #d84b6b; text-align: center; padding: 10px;">{{ $error }}</div>
                @endforeach
            @endif

            @yield('content')
        </div>

        <!-- The actual snackbar -->
        <div id="snackbar">Some text some message..</div>
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

        <!-- Google Adsense -->
        <script data-ad-client="ca-pub-4485968980278243" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

        <script>
            var is_mobile = false
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
                || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
              is_mobile = true;
            }

            if (is_mobile) {
                $('.main').addClass('scroll-hide-nav');
                $('#shareModal').remove();
            }
          </script>
    @show
</body>
</html>

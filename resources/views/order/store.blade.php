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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('layouts.nav')

        <div class="container" style="margin-top: 70px">
            <form class="order-form" action="{{ route('order.checkout', ['order' => $order]) }}" method="POST">
                {{ csrf_field() }}
                <h3 style="color: grey; font-weight: 300">填寫買家資料 &nbsp;<small style="font-size: 10px"><您的資料不會洩露給任何第三方></small></h3>
                <hr>

                <div class="container order-summary-content">
                    <div class="row">
                        <div class="col-md-2 col-xs-3" style="text-align: right;">
                            <h4>收件人：</h4>
                            <h4>聯絡電郵：</h4>
                            <h4 style="padding-top: 13px">聯絡電話：</h4>
                            <h4 style="padding-top: 16px">交收方式：</h4>
                        </div>
                        <div class="col-md-10 col-xs-9">
                            <h4>{{ Auth::user()->name }}</h4>
                            <h4>{{ Auth::user()->email }}</h4>
                            <h4><input style="margin-bottom: 0px;" type="text" value="{{ Auth::user()->phone }}" id="phone" name="phone" required></h4>
                            <select id="delivery" name="delivery" required>
                                <option value="">選擇交收方式...</option>
                                <option value="mtr">地鐵站交收</option>
                                <option value="home">送貨上門 ($0 限時免運費)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <h3 style="color: grey; font-weight: 300;">確認訂單詳情 &nbsp;</h3>
                <hr>

                <div class="container order-summary-content">
                    <div class="row">
                        <div class="col-md-2 col-xs-3" style="text-align: right;">
                            <h4>名稱：</h4>
                            <h4>價格：</h4>
                            <h4>數量：</h4>
                            <h4>收貨日期：</h4>
                            <h4>付款方式：</h4>
                        </div>
                        <div class="col-md-10 col-xs-9">
                            <h4>{{ $order->name }}</h4>
                            <h4>${{ $order->price }}</h4>
                            <h4>{{ $order->quantity }}</h4>
                            <h4>{{ $order->end_date }} 前</h4>
                            <h4>貨到支付</h4>
                        </div>
                    </div>
                </div>

                <div class="hidden-xs order-summary-content container" style="margin-top: 5px; width: 90%">
                    <div class="card-panel container order-product-section" style="margin-top: 15px; padding-top:5px; padding-bottom: 5px; border-radius: 2px;">
                        <div class="col-md-1">
                            <h4 style="text-align: center">#</h4>
                        </div>
                        <div class="col-md-8">
                            <h4>商品名稱</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>單價</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>數量</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>總額</h4>
                        </div>

                        <hr style="border-top: solid 0.5px #E6E6E6; margin: 45px 0 5px 0">

                        <div class="col-md-1">
                            <h4 style="text-align: center">1</h4>
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $order->name }}</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>${{ $order->price }}</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>{{ $order->quantity }}</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>${{ $total = $order->price * $order->quantity }}</h4>
                        </div>

                        <div class="col-md-12" style="text-align: right">
                            <h4 style="font-weight: bold">支付總額：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ${{ $total }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 visible-xs-block" style="text-align: right; border: solid 1px #f2f2f2">
                    <h4 style="font-weight: bold">支付總額：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ${{ $total }}</h4>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-xs-6 col-xs-offset-3">
                        <button type="submit" class="btn btn-info">提交訂單</button>
                    </div>
                </div>
            </form>
        </div>

        @include('layouts.footer')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
</body>
</html>

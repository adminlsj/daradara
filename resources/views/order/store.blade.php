<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
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
            <div class="card-panel" style="margin-bottom: -10px; height: 665px; border-width: 0px">
                <div>
                    <div class="col-md-12">
                        <h3>訂單詳情</h3>
                    </div>
                </div>

                <div class="col-md-12" style="background-color: #E6E6E6;">
                    <h4 style="line-height: 25px; margin-left: 50px">商品 #{{ $order->id }}</h4>
                </div>

                <div class="container order-summary-content">
                    <div class="col-md-2" style="text-align: right;">
                        <h4>名稱：</h4>
                        <h4>產地：</h4>
                        <h4>收貨日期：</h4>
                        <h4>發佈日期：</h4>
                        <h4>價格：</h4>
                    </div>
                    <div class="col-md-10">
                        <h4>{{ $order->name }}</h4>
                        <h4>{{ App\Order::$country[$order->country] }}</h4>
                        <h4>{{ $order->end_date }} 前</h4>
                        <h4>{{ Carbon\Carbon::now()->toDateString() }}</h4>
                        <h4>${{ $order->price }}</h4>
                    </div>
                </div>

                <div class="col-md-12" style="background-color: #E6E6E6;">
                    <h4 style="line-height: 25px; margin-left: 50px">買家資料</h4>
                </div>

                <div class="container order-summary-content">
                    <div class="col-md-2" style="text-align: right;">
                        <h4>買家：</h4>
                        <h4>買家聯絡：</h4>
                    </div>
                    <div class="col-md-10">
                        <h4>{{ Auth::user()->name }}</h4>
                        <h4>{{ Auth::user()->email }}</h4>
                    </div>
                </div>

                <div class="col-md-12" style="background-color: #E6E6E6;">
                    <h4 style="line-height: 25px; margin-left: 50px">商品訂購</h4>
                </div>

                <div class="order-summary-content container" style="margin-top: 60px; width: 90%">
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
                            <h4>1</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>${{ $total = $order->price }}</h4>
                        </div>

                        <div class="col-md-12" style="text-align: right">
                            <h4 style="font-weight: bold">支付總額：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ${{ $total }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 20px">
                    <div class="col-md-6">
                        <form style="text-align: right" action="{{ route('order.edit', ['order' => $order]) }}" method="GET">
                            <button style="width: 150px; border-radius: 200px; line-height: 30px" type="submit" class="btn btn-primary">修改訂單</button>
                            <br><br>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form style="text-align: left" id="purchaseForm" action="{{ route('order.checkout', ['order' => $order]) }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="stripeToken" id="stripeToken">
                            <input type="hidden" name="stripeEmail" id="stripeEmail">
                            <input type="hidden" name="quantity" value="1" id="quantity">
                            <!-- Trigger the modal with a button -->
                            <button style="width: 150px; border-radius: 0; line-height: 30px" type="button" class="btn btn-info" data-toggle="modal" data-target="#payModal">確認購買</button>
                            <!-- Modal -->
                            <div id="payModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">落單說明</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>1. 確認購買後，將跳轉至付款界面。</p>
                                            <p>2. 您所支付的金額只會在交易完成後，轉帳至賣家，以此保障雙方利益。</p>
                                            <p>3. 付款完成後，我們將會發送訂單的收據至您的電郵地址。</p>
                                            <p>4. 您可隨時取消訂單，並獲得全額退款。</p>
                                            <br>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" style="border-radius: 2px;" class="btn btn-default" data-dismiss="modal">返回</button>
                                            <button id="purchaseBtn" type="submit" style="border-radius: 2px !important" class="btn btn-info">立即付款</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                        </form>
                    </div> 
                </div>
            </div>
            <br><br><br>
        </div>

        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script>
            var handler = StripeCheckout.configure({
                key: "{{ config('services.stripe.key') }}",
                image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                locale: 'en',
                token: function(token) {
                    document.querySelector('#stripeToken').value = token.id;
                    document.querySelector('#stripeEmail').value = token.email;
                    document.querySelector('#purchaseForm').submit();
                }
            });

            document.getElementById('purchaseBtn').addEventListener('click', function(e) {
                $('#payModal').modal('hide');
                // Open Checkout with further options:
                var quantity = 1;
                handler.open({
                    name: 'FreeRider',
                    description: '{{ $order->name }}',
                    zipCode: true,
                    currency: 'hkd',
                    amount: {{ $order->price }} * 100
                });
                e.preventDefault();
            });

            // Close Checkout on page navigation:
            window.addEventListener('popstate', function() {
                handler.close();
            });
        </script>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
</body>
</html>

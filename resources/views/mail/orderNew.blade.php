@component('mail::message')
# 我們已受到您的訂單 {{ $order->name }}

@component('mail::table')
| 商品名稱                | 單價                  | 數量                    | 支付總額                                 |
| :--------------------: | :------------------: | :--------------------: | :-------------------------------------: |
| {{ $order->name }}     | ${{ $order->price }} | {{ $order->quantity }} | ${{ $order->price * $order->quantity }} |
@endcomponent

FreeRider正在光速採購您的訂單！我們承諾會在7日內交收，並只在貨到時收取相關款項。

確實的交易時間與地點將在採購完成後，馬上通知您落實。

感謝您使用 FreeRider！

@component('mail::button', ['url' => route('order.index')])
我的訂單
@endcomponent

感謝您使用 FreeRider,<br>
{{ config('app.name') }}
@endcomponent

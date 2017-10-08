@component('mail::message')
# 您的訂單 {{ $order->name }} 已取消

我們已收到您的取消請求，相關款項將於7天內退還至付款帳戶。
我們為帶來的不便，深感抱歉。

@component('mail::button', ['url' => route('order.index')])
我的訂單
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

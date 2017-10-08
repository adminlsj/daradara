@component('mail::message')
# 我們已受到您的訂單 {{ $order->name }} 的付款

此訂單正在等待 Freerider 接單。您可隨時取消訂單並全額退款。

@component('mail::button', ['url' => route('order.index')])
我的訂單
@endcomponent

感謝您使用 FreeRider,<br>
{{ config('app.name') }}
@endcomponent

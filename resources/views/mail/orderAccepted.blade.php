@component('mail::message')
# 您的訂單 {{ $order->name }} 已被接單

FreeRider 現正火速採購您的訂單！

@component('mail::button', ['url' => route('order.index')])
我的訂單
@endcomponent

感謝您使用 FreeRider,<br>
{{ config('app.name') }}
@endcomponent

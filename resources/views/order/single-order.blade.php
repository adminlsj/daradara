<div class="card-order">
    <a href="{{ route('order.show', ['order' => $order->id]) }}">
        <img style="{{ $radius }}" id="order-img" class="d-block img-responsive single-order-outer" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $order->orderImgs->first()->order_id }}/{{ $order->orderImgs->first()->filename }}.jpg">
        <div id="img-text" style="background-color: rgba(45,45,45,0.7) ; padding: 5px 15px 5px 15px; border-top-left-radius: 3px; border-bottom-right-radius: 2px;">${{ $order->price }}</div>
        <div id="img-name" class="text-center" style="width: 99%"><h5 style="color: #666666">{{ str_limit($order->name, 30) }}</h5></div>
    </a>
</div>
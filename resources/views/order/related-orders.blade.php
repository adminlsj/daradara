@foreach($relatedOrders as $order)
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-5">
            <a href="{{ route('order.show', ['order' => $order->id]) }}">
                    <img style="border: solid 1px #f2f2f2" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $order->id }}/{{ $order->orderImgs->first()->filename }}.jpg" class="img-responsive img-circle">
            </a>
        </div>
        <div class="col-md-7">
            <div><a href="{{ route('order.show', ['order' => $order->id]) }}"><h3 style="color: black; font-weight: 400; font-size: 15px">{{ str_limit($order->name, 50) }}</h3></a></div>
            <div style="font-size: 12.5px;"><span style="font-weight: 600;">${{ $order->price }}</span> + $0 服務費</div>
            <div style="font-size: 12.5px">{{ $order->end_date }} 前</div>
        </div>
    </div>
@endforeach


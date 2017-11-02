<h3 style="color: grey; font-weight: 300">為您推薦的貼文</h3>
<hr>
@foreach($relatedBlogs as $blog)
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-5">
            <a href="{{ route('blog.show', ['blog' => $blog->id]) }}">
                <img src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/squares/{{ $blog->id }}/{{ $blog->blogImgs->first()->filename }}" class="img-responsive img-circle">
            </a>
        </div>
        <div class="col-md-7">
            <div><a href="{{ route('blog.show', ['blog' => $blog->id]) }}"><h3 style="color: black; font-weight: 400; font-size: 15px">{{ str_limit($blog->title, 50) }}</h3></a></div>
            <div style="font-size: 12.5px">{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日') }}</div>
        </div>
    </div>
@endforeach
<br>

<h3 style="color: grey; font-weight: 300; margin-top: 15px">為您推薦的商品</h3>
<hr>
@foreach($relatedOrders as $order)
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-5">
            <a href="{{ route('order.show', ['order' => $order->id]) }}">
                    <img src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $order->id }}/{{ $order->orderImgs->first()->filename }}.jpg" class="img-responsive img-circle">
            </a>
        </div>
        <div class="col-md-7">
            <div><a href="{{ route('order.show', ['order' => $order->id]) }}"><h3 style="color: black; font-weight: 400; font-size: 15px">{{ str_limit($order->name, 50) }}</h3></a></div>
            <div style="font-size: 12.5px">${{ $order->price }} + $0 服務費</div>
            <div style="font-size: 12.5px">{{ $order->end_date }} 前</div>
        </div>
    </div>
@endforeach
<br>
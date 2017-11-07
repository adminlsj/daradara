@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
    <div class="row">
    	<div class="col-md-8">
			<div id="pre">
				<h3 style="color: grey; font-weight: 300">等待中的訂單</h3>
				<hr>
				@foreach ($pre as $order)
					<div class="row">
						<div class="col-md-2">
							<a href="{{ route('order.show', ['order' => $order->id]) }}"><img class="img-responsive img-rounded" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $order->id }}/{{ $order->orderImgs->first()->filename }}.jpg" alt="First slide"></a>
						</div>
						<div class="col-md-8">
							<div style="padding-top:2px; margin-bottom: 7px"><a style="color: black; font-weight: 400; font-size: 18px;" href="{{ route('order.show', ['order' => $order->id]) }}">{{ $order->name }}</a>
							&nbsp;&nbsp;<small>(已付款)</small></div>
							<div style="margin-bottom: 3px; font-size: 13px;">收貨日期：{{ $order->end_date }} 前</div>
							<div><span style="font-weight: 400; font-size: 13px;">${{ $order->price }} + $0 限時免運費</span></div>
						</div>
						<div class="visible-xs-block" style="margin-top: 7px;"></div>
						<div class="col-md-2 order-show">
							<div class="row">
								<!-- Trigger the modal with a button -->
								<div class="col-md-12 col-xs-6"><a class="btn btn-info order-index-btn" data-toggle="modal" data-target="#cancelModal{{$order->id}}">取消訂單</a></div>
								<!-- Modal -->
								<div id="cancelModal{{$order->id}}" style="z-index: 10000" class="modal fade" role="dialog">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">取消訂單</h4>
											</div>
											<div class="modal-body">
												<p>確認取消訂單嗎？</p>
												<p>我們承諾能在7天內送貨上門。</p>
											</div>
											<div class="modal-footer">
												<button type="button" style="border-radius: 2px;" class="btn btn-default" data-dismiss="modal">返回</button>
												<a href="/orders/{{ $order->id }}/cancel" type="submit" style="border-radius: 2px !important; width: auto;" class="btn btn-info">取消訂單</a>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-12 col-xs-6"><a href="/contact" style="margin-top: 7px" class="btn btn-primary order-index-btn">聯絡我們</a></div>
							</div>
						</div>
					</div>
					<hr>
				@endforeach
			</div>

			<div id="current">
				<h3 style="color: grey; font-weight: 300">進行中的訂單</h3>
				<hr>
				@foreach ($current as $order)
					<div class="row">
						<div class="col-md-2">
							<a href="{{ route('order.show', ['order' => $order->id]) }}"><img class="img-responsive img-rounded" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $order->id }}/{{ $order->orderImgs->first()->filename }}.jpg" alt="First slide"></a>
						</div>
						<div class="col-md-8">
							<div style="padding-top:2px;"><a style="color: black; font-weight: 400; font-size: 18px;" href="{{ route('order.show', ['order' => $order->id]) }}">{{ $order->name }}</a></div>
							<div style="margin-bottom: 7px"><small>{{ $order->trans->is_arrived ? '(已入庫存等待交收中)' : '(Freerider '.$order->trans->user->name.' 火速採購中)' }}</small></div>
							<div style="margin-bottom: 3px; font-size: 13px;">收貨日期：{{ $order->end_date }} 前</div>
							<div><span style="font-weight: 400; font-size: 13px;">${{ $order->price }} + $0 限時免運費</span></div>
						</div>
						<div class="visible-xs-block" style="margin-top: 7px;"></div>
						<div class="col-md-2">
							<div class="row">
								<!-- Trigger the modal with a button -->
								<div class="order-show">
									<div class="col-md-12 col-xs-6"><button type="button" class="btn btn-info order-index-btn" data-toggle="modal" data-target="#myModal">馬上交收</button></div>
								</div>

								<!-- Modal -->
								<form action="/sendMail/meetup" method="POST">
									{{ csrf_field() }}
									<div id="myModal" class="modal fade" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">交收詳情</h4>
												</div>
												<div class="modal-body">
													<p>請選擇交收的地點與時段：</p>
													<br>
													<div class="form-group row margin-0">
														<label for="email" class="col-md-2 text-center"><h5>Email</h5></label>
													    <div class="col-md-10">
														    <input class="form-control" type="text" value="" id="email" name="email" required>
													    </div>
													</div>
													<div class="form-group row margin-0">
														<label for="location" class="col-md-2 text-center"><h5>地點</h5></label>
													    <div class="col-md-10">
														    <input class="form-control" type="text" value="" id="location" name="location" required>
													    </div>
													</div>
													<div class="form-group row margin-0">
														<label for="time" class="col-md-2 text-center"><h5>時間</h5></label>
													    <div class="col-md-10">
														    <input class="form-control" type="text" value="" id="time" name="time" required>
													    </div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-info">Send</button>
												</div>
											</div>
										</div>
									</div>
								</form>
								<div class="order-show">
									<div class="col-md-12 col-xs-6"><a href="/contact" class="btn btn-primary order-index-btn" style="margin-top: 7px">聯絡我們</a></div>
								</div>
							</div>
						</div>
					</div>
					<hr>
				@endforeach
			</div>

			<div id="past">
				<h3 style="color: grey; font-weight: 300">過去的訂單</h3>
				<hr>
				@foreach ($past as $order)
					<div class="row">
						<div class="col-md-2">
							<a href="{{ route('order.show', ['order' => $order->id]) }}"><img class="img-responsive img-rounded" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $order->id }}/{{ $order->orderImgs->first()->filename }}.jpg" alt="First slide"></a>
						</div>
						<div class="col-md-8">
							<div style="padding-top:2px; margin-bottom: 7px"><a style="color: black; font-weight: 400; font-size: 18px;" href="{{ route('order.show', ['order' => $order->id]) }}">{{ $order->name }}</a>
							&nbsp;&nbsp;<small>(已付款)</small></div>
							<div style="margin-bottom: 3px; font-size: 13px;">收貨日期：{{ $order->end_date }} 前</div>
							<div><span style="font-weight: 400; font-size: 13px;">${{ $order->price }} + $0 限時免運費</span></div>
						</div>
						<div class="visible-xs-block" style="margin-top: 7px;"></div>
						<div class="col-md-2">
							<div class="row">
								<form class="order-show" action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
									{{ csrf_field() }}
									<input type="hidden" name="name" id="name" value="{{ $order->name }}">
									<input type="hidden" name="price" id="price" value="{{ $order->price }}">
									<input type="hidden" name="category" id="category" value="{{ $order->category }}">
									<input type="hidden" name="country" id="country" value="{{ $order->country }}">
									<input type="hidden" name="description" id="description" value="{{ $order->description }}">
									<input type="hidden" name="link" id="link" value="{{ $order->link }}">
									<input type="hidden" name="endDate" id="endDate" value="{{ Carbon\Carbon::today()->addDays(7)->format('Y-m-d') }}">
									<input type="hidden" name="copyOrderId" id="copyOrderId" value="{{ $order->id }}">
									<input type="hidden" name="quantity" id="quantity" value="{{ $order->quantity }}">

									<div class="col-md-12 col-xs-6">
										<button type="submit" class="btn btn-info order-index-btn">重新下單</button>
									</div>
								</form>
								<div class="order-show">
									<div class="col-md-12 col-xs-6">
										<a href="/contact" style="margin-top: 7px" class="btn btn-primary order-index-btn">聯絡我們</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr>
				@endforeach
			</div>
        </div>
        <div class="col-md-4" style="padding-left: 25px">
			<h3 style="color: grey; font-weight: 300">為您推薦的商品</h3>
			<hr>
			<div class="col-md-12">
			@include('order.related-orders')
			</div>
			<br>
		</div>
    </div>
</div>

<script>
	function openStatus(evt, cityName) {
	    var i, tabcontent, tablinks;
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }
	    tablinks = document.getElementsByClassName("tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }
	    document.getElementById(cityName).style.display = "block";
	    evt.currentTarget.className += " active";
	}

	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();
</script>
      
@endsection
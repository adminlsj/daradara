@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
    <div class="row">
    	<div class="col-md-8">
			<div id="pre">
				<h3 style="color: grey; font-weight: 300">進行中的接單</h3>
				<hr>
				@foreach ($pre as $tran)
					<div class="row">
						<div class="col-md-2">
							<a href="{{ route('order.show', ['order' => $tran->order->id]) }}"><img class="img-responsive img-rounded" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $tran->order->id }}/{{ $tran->order->orderImgs->first()->filename }}.jpg" alt="First slide"></a>
						</div>
						<div class="col-md-8">
							<div style="padding-top:2px;"><a style="color: black; font-weight: 400; font-size: 18px;" href="{{ route('order.show', ['order' => $tran->order->id]) }}">{{ $tran->order->name }}</a></div>
							<div style="margin-bottom: 7px"><small>(買家已預先付款)</small></div>
							<div style="margin-bottom: 3px; font-size: 13px;">收貨日期：{{ $tran->order->end_date }} 前</div>
							<div><span style="font-weight: 400; font-size: 13px;">${{ $tran->order->price }} + $0 服務費</span></div>
						</div>
						<div class="col-md-2">
							<!-- Trigger the modal with a button -->
							<button type="button" style="border-radius: 2px 2px 0px 0px !important; padding: 15px 25px 15px 25px" class="btn btn-info" data-toggle="modal" data-target="#myModal">馬上交收</button>

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
												<button type="submit" style="border-radius: 3px !important" class="btn btn-info">Send</button>
											</div>
										</div>
									</div>
								</div>
							</form>

							<a href="/contact" style="border-radius: 0 0 2px 2px !important; padding: 15px 25px 15px 25px" class="btn btn-primary">聯絡我們</a>
						</div>
					</div>
					<hr>
				@endforeach
			</div>

			<div id="current">
				<h3 style="color: grey; font-weight: 300">完成的接單</h3>
				<hr>
				@foreach ($current as $tran)
					<div class="row">
						<div class="col-md-2">
							<a href="{{ route('order.show', ['order' => $tran->order->id]) }}"><img class="img-responsive img-rounded" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $tran->order->id }}/{{ $tran->order->orderImgs->first()->filename }}.jpg" alt="First slide"></a>
						</div>
						<div class="col-md-8">
							<div style="padding-top:2px; margin-bottom: 7px"><a style="color: black; font-weight: 400; font-size: 18px;" href="{{ route('order.show', ['order' => $tran->order->id]) }}">{{ $tran->order->name }}</a></div>
							<div style="margin-bottom: 3px; font-size: 13px;">收貨日期：{{ $tran->order->end_date }} 前</div>
							<div><span style="font-weight: 400; font-size: 13px;">${{ $tran->order->price }} + $0 服務費</span></div>
						</div>
						<div class="col-md-2">
							<a href="/contact" style="border-radius: 2px !important; padding: 15px 25px 15px 25px" class="btn btn-primary">聯絡我們</a>
						</div>
					</div>
					<hr>
				@endforeach
			</div>

			<div id="past">
				<h3 style="color: grey; font-weight: 300">未完成的接單</h3>
				<hr>
				@foreach ($past as $tran)
					<div class="row">
						<div class="col-md-2">
							<a href="{{ route('order.show', ['order' => $tran->order->id]) }}"><img class="img-responsive img-rounded" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $tran->order->id }}/{{ $tran->order->orderImgs->first()->filename }}.jpg" alt="First slide"></a>
						</div>
						<div class="col-md-8">
							<div style="padding-top:2px;"><a style="color: black; font-weight: 400; font-size: 18px;" href="{{ route('order.show', ['order' => $tran->order->id]) }}">{{ $tran->order->name }}</a></div>
							<div style="margin-bottom: 7px"><small>(買家已預先付款)</small></div>
							<div style="margin-bottom: 3px; font-size: 13px;">收貨日期：{{ $tran->order->end_date }} 前</div>
							<div><span style="font-weight: 400; font-size: 13px;">${{ $tran->order->price }} + $0 服務費</span></div>
						</div>
						<div class="col-md-2">
							<a href="/contact" style="border-radius: 2px !important; padding: 15px 25px 15px 25px" class="btn btn-primary">聯絡我們</a>
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
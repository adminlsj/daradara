@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
	<div class="row">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="owl-carousel owl-theme">
						@foreach ($order->orderImgs as $image)
							<div>
						        <img style="border-radius: 2px" class="img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/originals/{{ $image->order_id }}/{{ $image->filename }}.jpg" alt="First slide">
					        </div>
					    @endforeach
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<h3 style="color: black; font-weight: 400">{{ $order->name }}</h3>
					<p>發佈日期：{{ $order->created_at }}</p>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-2">
					<a href="{{ route('user.show', ['user' => $order->user]) }}"><img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/thumbnails/{{ $order->user->avatar->filename }}.jpg" class="img-responsive img-circle"></a>
				</div>
				<div class="col-md-6">
					<div><h3 style="color: black; font-weight: 400; margin-top: 15px">${{ $order->price }} + $0 服務費</h3></div>
					<div>產地：{{ App\Order::$country[$order->country] }}</div>
					<div>收貨日期：{{ $order->end_date }} 前</div>
				</div>
				<div class="col-md-4">
					<form style="margin-top: 5%" action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="name" id="name" value="{{ $order->name }}">
						<input type="hidden" name="price" id="price" value="{{ $order->price }}">
						<input type="hidden" name="category" id="category" value="{{ $order->category }}">
						<input type="hidden" name="country" id="country" value="{{ $order->country }}">
						<input type="hidden" name="description" id="description" value="{{ $order->description }}">
						<input type="hidden" name="link" id="link" value="{{ $order->link }}">
						<input type="hidden" name="endDate" id="endDate" value="{{ Carbon\Carbon::today()->addDays(10)->format('Y-m-d') }}">
						<input type="hidden" name="copyOrderId" id="copyOrderId" value="{{ $order->id }}">

						<button type="submit" style="border-radius: 0px !important; font-size:15px" class="btn btn-info btn-lg btn-block">我也想要</button>
					</form>

					<form action="{{ route('tran.store') }}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input name="order_id" type="hidden" value="{{ $order->id }}">
						@if (!$order->is_payed || $order->trans || $order->end_date < Carbon\Carbon::today())
							<button type="submit" style="border-radius: 0; font-size:15px" class="btn btn-primary btn-outline btn-lg btn-block" disabled='true'>接單</button>
						@else
				            <button type="submit" style="border-radius: 0; font-size:15px" class="btn btn-primary btn-outline btn-lg btn-block">接單</button>
						@endif
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-2">
					<h5 style="font-weight: 400; line-height: 20px">{{ $order->description }}</h5>
					<h5 style="margin-top: 20px; line-height: 20px">相關網址：<a href="{{ $order->link }}" target="_blank">{{ $order->link }}</a></h5>
				</div>
			</div>
			<hr>
			<div class="row">
	            <div class="col-md-12">
					<h3 id="comments-count" style="color: black; font-weight: 400">商品評論 ({{ $order->comments->count() }})</h3>
					<div id="comment" class="tab-pane"> <!-- class fade -->
		            	@if (Auth::check())
		            		@include('comment.create')
		            	@endif
		                @include('comment.index')
			        </div>
				</div>
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
	$(document).ready(function(){
		$('.owl-carousel').owlCarousel({
			items: 1,
			loop: true,
			nav: true,
			dots: false,
			lazyLoad: true,
			autoplay: false,
			navText : ['<i class="material-icons" style="font-size:36px">keyboard_arrow_left</i>','<i class="material-icons" style="font-size:36px">keyboard_arrow_right</i>']
		});
	});
</script>

@endsection
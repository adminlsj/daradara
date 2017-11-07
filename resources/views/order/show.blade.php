@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
	<ol class="arrows" style="padding:10px 0px 10px 0px; margin:0; background-color: white">
	    <li><a href="/orders/search?name=&category=&country={{$order->country}}&price=">{{ App\Order::$country[$order->country] }}</a></li>
	    <li><a href="/orders/search?name=&category={{$order->category}}&country=&price=">{{ App\Order::$category[$order->category] }}</a></li>
	    <li class="hidden-xs"><a href="/orders/search?name=&category={{$order->category}}&country=&price=">{{$order->name}}</a></li>
	</ol>
	<div class="row">
		<div class="col-md-8">
			<div class="row hidden-xs" style="margin-top: 20px">
				<div class="col-md-12">
					<div class="order-tab">
						@foreach ($order->orderImgs as $image)
							<button class="tablinks" onclick="openCity(event, '{{ $image->filename }}')" {{ $image->filename == $order->orderImgs->first()->filename ? "id=defaultOpen" : '' }}>
								<img class="img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/thumbnails/{{ $image->order_id }}/{{ $image->filename }}.jpg" alt="First slide">
							</button>
						@endforeach
					</div>

					@foreach ($order->orderImgs as $image)
						<div id="{{ $image->filename }}" class="order-tabcontent">
							<img style="border-radius: 2px; border-top-left-radius: 0px" class="img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/originals/{{ $image->order_id }}/{{ $image->filename }}.jpg" alt="First slide">
						</div>
					@endforeach
				</div>
			</div>

			<div class="col-md-8 visible-xs-block">
				<div class="order-mobile-carousel owl-carousel owl-theme">
					@foreach ($order->orderImgs as $image)
						<img style="border-radius: 2px;" class="img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/originals/{{ $image->order_id }}/{{ $image->filename }}.jpg" alt="First slide">
					@endforeach
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
				<div class="col-md-2 col-xs-4">
					<a href="/orders/search?name="><img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/thumbnails/{{ $order->user->avatar->filename }}.jpg" class="img-responsive img-circle"></a>
					<img style="margin-top: 20px" class="visible-xs-block img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/system/intro/delivery.jpg" alt="First slide">
				</div>
				<div class="col-md-7 col-xs-8">
					<div><h3 style="color: black; font-weight: 400; margin-top: 15px"><span style="font-weight: 800 !important">${{ $order->price }}</span>&nbsp;<small> + $0 限時免運費</small></h3></div>
					<div>分類：<a href="/orders/search?name=&category=&country={{$order->country}}&price=">{{ App\Order::$country[$order->country] }}</a> | <a href="/orders/search?name=&category={{$order->category}}&country=&price=">{{ App\Order::$category[$order->category] }}</a></div>
					<div>送貨：九龍 | 新界 | 香港島</div>

					<form class="" style="margin-top: 7px" action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="name" id="name" value="{{ $order->name }}">
						<input type="hidden" name="price" id="price" value="{{ $order->price }}">
						<input type="hidden" name="category" id="category" value="{{ $order->category }}">
						<input type="hidden" name="country" id="country" value="{{ $order->country }}">
						<input type="hidden" name="description" id="description" value="{{ $order->description }}">
						<input type="hidden" name="link" id="link" value="{{ $order->link }}">
						<input type="hidden" name="endDate" id="endDate" value="{{ Carbon\Carbon::today()->addDays(7)->format('Y-m-d') }}">
						<input type="hidden" name="copyOrderId" id="copyOrderId" value="{{ $order->id }}">
						
						<br>

						<div class="row">
							<div class="col-md-2 col-xs-2">
								<div class="quantity" style="display: inline-block;">
									<input type="number" name="quantity" id="quantity" min="1" max="9" step="1" value="1">
								</div>
							</div>

							<div id="order-purchase-btn" class="col-md-10 col-xs-10" style="padding-top:0.9px; padding-left: 25px;">
								<div><button type="submit" style="border-radius: 2px !important; font-size: 15px;" class="btn btn-info btn-lg btn-block">立即購買</button></div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-3 col-xs-12 hidden-xs">
					<img class="img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/system/intro/delivery.jpg" alt="First slide">
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-2">
					<h5 style="font-weight: 400; line-height: 20px; white-space: pre-line;">{{ $order->description }}</h5>
					<h5 style="margin-top: 20px; line-height: 20px">相關網址：<a style="word-wrap: break-word;" href="{{ url($order->link) }}" target="_blank">{{ $order->link }}</a></h5>
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
		<div id="order-show-sidebar" class="col-md-4">
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
		$('.order-mobile-carousel').owlCarousel({
			items: 1,
			loop: true,
			nav: false,
			dots: true,
			lazyLoad: true,
			autoplay: false,
		});
	});

	function openCity(evt, cityName) {
	    // Declare all variables
	    var i, tabcontent, tablinks;

	    // Get all elements with class="tabcontent" and hide them
	    tabcontent = document.getElementsByClassName("order-tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }

	    // Get all elements with class="tablinks" and remove the class "active"
	    tablinks = document.getElementsByClassName("tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }

	    // Show the current tab, and add an "active" class to the link that opened the tab
	    document.getElementById(cityName).style.display = "block";
	    evt.currentTarget.className += " active";
	}

	document.getElementById("defaultOpen").click();
</script>

@endsection
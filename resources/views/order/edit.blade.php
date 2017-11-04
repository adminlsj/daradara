@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
	<div class="row">
    	<div class="col-md-8">
			<h3 style="color: grey; font-weight: 300">等待中的訂單</h3>
			<hr>
			<form class="order-form" action="{{ route('order.update', ['order' => $order]) }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<div class="row">
					<div class="col-md-8">
					    <input type="text" value="{{ old ('name', $order->name) }}" id="name" name="name" placeholder="訂單名稱" required>
					</div>
					<div class="col-md-4">
					    <input type="integer" value="{{ old ('price', $order->price) }}" id="price" name="price" placeholder="價格" required>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
					    <select id="category" name="category">
					    	<option value="">選擇分類...</option>
					    	@foreach (App\Order::$category as $key => $element)
								<option {{ old('category', $order->category) == $key ? 'selected' : '' }} value="{{ $key }}">{{ $element }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-4">
					    <select id="country" name="country">
					    	<option value="">選擇國家...</option>
					    	@foreach (App\Order::$country as $key => $element)
								<option {{ old('country', $order->country) == $key ? 'selected' : '' }} value="{{ $key }}">{{ $element }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-4">
					    <input type="date" value="{{ old ('endDate', $order->end_date) }}" id="endDate" name="endDate" required>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
					    <input type="text" value="{{ old ('link', $order->link) }}" id="link" name="link" placeholder="相關網址" required>
					</div>
				</div>

				<div class="row" style="margin-top: 5px">
					<div class="col-md-12">
					    <textarea style="width: 100%; padding: 10px; border-color: #AAA" type="text" id="description" name="description" placeholder="詳細描述" rows="5" required>{{ old ('description', $order->description) }}</textarea>
					</div>
				</div>
				<br class="hidden-xs">
				<div class="row">
					<div class="col-md-12">
						<div class="owl-carousel owl-theme">
							@foreach ($order->orderImgs as $image)
								<div>
							        <img style="border-radius: 2px" class="img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/orderImgs/originals/{{ $image->order_id }}/{{ $image->filename }}.jpg">
						        </div>
						    @endforeach
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<button type="submit" class="btn btn-info btn-outline btn-lg btn-block">提交訂單</button>
					</div>
				</div>
			</form>
		</div>

		<br class="visible-xs-block visible-sm-block">
		<br class="visible-xs-block visible-sm-block">
		<br class="visible-xs-block visible-sm-block">

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
			nav: false,
			dots: true,
			lazyLoad: true,
			autoplay: true,
		});
	});
</script>

@endsection

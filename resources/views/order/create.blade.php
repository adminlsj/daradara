@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
	<div class="row">
    	<div class="col-md-8">
			<h3 style="color: grey; font-weight: 300">等待中的訂單</h3>
			<hr>
			<form class="order-form" action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-8">
					    <input type="text" value="" id="name" name="name" placeholder="訂單名稱" required>
					</div>
					<div class="col-md-4">
					    <input type="integer" value="" id="price" name="price" placeholder="價格" required>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
					    <select id="category" name="category">
					    	<option value="">選擇分類...</option>
					    	@foreach (App\Order::$category as $key => $element)
								<option value="{{ $key }}">{{ $element }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-4">
					    <select id="country" name="country">
					    	<option value="">選擇國家...</option>
					    	@foreach (App\Order::$country as $key => $element)
								<option value="{{ $key }}">{{ $element }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-4">
					    <input type="date" value="{{ Carbon\Carbon::tomorrow()->format('Y-m-d') }}" id="endDate" name="endDate" required>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
					    <input type="text" value="" id="link" name="link" placeholder="相關網址" required>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
					    <input type="text" value="" id="description" name="description" placeholder="詳細描述" required>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<input id="orderImgs" name="orderImgs[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true">
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<br>
						<button type="submit" class="btn btn-info btn-outline btn-lg btn-block">提交訂單</button>
					</div>
				</div>
			</form>
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

@endsection

<form id="search-form" class="order-form" action="{{ route('order.search') }}" method="GET">
	<div class="row sidenav" style="margin-top: 20px">
		<div class="col-md-10 col-md-offset-1">
			<input style="padding: 4px;" type="text" value="{{ request('name') }}" id="name" name="name" placeholder="名稱">
		</div>
	</div>

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<select id="category" name="category">
				<option value="">選擇分類...</option>
				@foreach (App\Order::$category as $key => $element)
					<option value="{{ $key }}" {{ request('category') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="row" style="margin-top: 7px">
		<div class="col-md-10 col-md-offset-1">
			<select id="country" name="country">
				<option value="">選擇國家...</option>
				@foreach (App\Order::$country as $key => $element)
					<option value="{{ $key }}" {{ request('country') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="row sidenav" style="margin-top: 8px">
		<div class="col-md-10 col-md-offset-1">
			<input style="padding: 4px;" type="integer" value="{{ request('price') }}" id="price" name="price" placeholder="此價格以內">
		</div>
	</div>

	<div class="row sidenav" style="margin-top: 5px">
		<div class="col-md-8 col-md-offset-2">
			<button type="submit" class="btn btn-info btn-block">搜索</button>
		</div>
	</div>
</form>


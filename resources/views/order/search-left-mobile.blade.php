<form id="search-form" class="order-form" action="{{ route('order.search') }}" method="GET">
	<div class="row">
		<div class="col-xs-4" style="padding-top: 7px; padding-left: 7%">
			<select onchange="this.form.submit()" id="country" name="country" style="border: none; border-right: solid 1px #E6E6E6;">
				<option value="">選擇國家...</option>
				@foreach (App\Order::$country as $key => $element)
					<option value="{{ $key }}" {{ request('country') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>

		<div class="col-xs-4" style="padding-top: 7px">
			<select onchange="this.form.submit()" id="category" name="category" style="border: none; border-right: solid 1px #E6E6E6;">
				<option value="">選擇分類...</option>
				@foreach (App\Order::$category as $key => $element)
					<option value="{{ $key }}" {{ request('category') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>

		<div class="col-xs-4">
			<input onchange="this.form.submit()" style="border: none; padding-top: 16px;" type="integer" value="{{ request('price') }}" id="price" name="price" placeholder="此價格以內">
		</div>
	</div>
</form>
@if(Auth::check())
	<form id="storeComment" class="order-form" action="{{route('order.comment.store', ['order' => $order->id])}}" method="POST">
		{{ csrf_field() }}
		<div class="row bottom-btn-row">
			<div class="col-md-1">
				<a href="/orders/search?name="><img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/thumbnails/{{ auth()->user()->avatar->filename }}.jpg" class="img-responsive img-circle"></a>
			</div>
			<div class="form-group col-md-9">
				<div class="row">
				    <input style="margin-top: 4px; padding: 3px" type="text" value="" id="commentBox" name="text" placeholder="留下您的足跡..." required>
				</div>
			</div>
			<div class="form-group col-md-2 bottom-align-text">
				<button id="commentBtn" type="submit" class="btn btn-info btn-block" style="border-radius: 2px !important">評論</button>
			</div>
		</div>
	</form>
    <hr style="margin: 8px 0 24px 0">
@endif
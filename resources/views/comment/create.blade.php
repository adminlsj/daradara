@if(Auth::check())
	<form id="storeComment" action="{{route('order.comment.store', ['order' => $order->id])}}" method="POST">
		{{ csrf_field() }}
		<div class="row bottom-btn-row">
			<div class="col-md-1">
				<a href="{{ route('user.show', ['user' => auth()->user()->id]) }}"><img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/thumbnails/{{ auth()->user()->avatar->filename }}.jpg" class="img-responsive img-circle"></a>
			</div>
			<div class="form-group col-md-9">
				<div class="row">
				    <textarea class="form-control" id="commentBox" name='text' style="line-height: 25px" rows="2" placeholder="Add a comment"></textarea>
				</div>
			</div>
			<div class="form-group col-md-2 bottom-align-text">
				<button id="commentBtn" type="submit" class="btn btn-info btn-outline btn-block">評論</button>
			</div>
		</div>
	</form>
    <hr style="margin: 8px 0 24px 0">
@endif
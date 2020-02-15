@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray", 'menuBtnColor' => '#595959'])
@endsection

@section('content')

<form action="{{ route('category.update') }}" method="POST" style="padding-top: 15px;" class="padding-setup mobile-container">
	{{ csrf_field() }}
	<iframe src='http://api.bilibili.com/x/player/playurl?avid=70534327&cid=123691341&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1'></iframe>

	<div class="form-group">
		<label for="category">Category</label>
		<input type="text" class="form-control" name="category" id="category">
	</div>

	<div class="form-group">
		<label for="sourceLinks">Source Links</label>
		<textarea class="form-control" name="sourceLinks" id="sourceLinks" rows="20"></textarea>
	</div>

	<button type="submit" class="btn btn-info">Submit</button>
	<br><br>
</form>

@endsection
@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray", 'menuBtnColor' => '#595959'])
@endsection

@section('content')

<form action="{{ route('single.store') }}" method="POST" style="padding-top: 15px;" class="padding-setup mobile-container">
	{{ csrf_field() }}

	<div class="form-group">
		<label for="category">Category</label>
		<input type="text" class="form-control" name="category" id="category">
	</div>

	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" class="form-control" name="title" id="title" placeholder="(optional)">
	</div>

	<div class="form-group">
		<label for="caption">Caption</label>
		<input type="text" class="form-control" name="caption" id="caption" placeholder="(optional)">
	</div>

	<div class="form-group">
		<label for="link">Link</label>
		<input type="text" class="form-control" name="link" id="link">
	</div>

	<div class="form-group">
		<label for="imgur">Imgur</label>
		<input type="text" class="form-control" name="imgur" id="imgur">
	</div>

	<div class="form-group">
		<label for="tags">Tags</label>
		<input type="text" class="form-control" name="tags" id="tags" placeholder="(optional)">
	</div>

	<div class="form-group">
		<label for="views">Views</label>
		<input type="text" class="form-control" name="views" id="views" placeholder="(optional)">
	</div>

	<div class="form-group">
		<label for="created_at">Created At</label>
		<input type="datetime-local" class="form-control" name="created_at" id="created_at" placeholder="(optional)" value="{{ Carbon\Carbon::now()->addHours(8)->format('Y-m-d\Th:i:s') }}">
	</div>

	<button type="submit" class="btn btn-info">Submit</button>
	<br><br>
</form>

@endsection
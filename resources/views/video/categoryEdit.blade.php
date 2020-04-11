@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<form action="{{ route('category.update') }}" method="POST" style="padding-top: 15px;" class="padding-setup mobile-container">
	{{ csrf_field() }}

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
@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')

<form id="singleNewCreateForm" action="{{ route('single.store') }}" method="POST" style="padding-top: 15px;" class="padding-setup mobile-container">
	{{ csrf_field() }}

	<input id="duration" name="duration" type="hidden" value="">

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
		<textarea class="form-control" name="caption" id="caption" rows="3"></textarea>
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
		<input type="datetime-local" class="form-control" name="created_at" id="created_at" placeholder="(optional)" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}">
	</div>

	<div class="form-group">
		<label for="uploaded_at">Uploaded At</label>
		<input type="datetime-local" class="form-control" name="uploaded_at" id="uploaded_at" placeholder="(optional)" value="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i:s') }}">
	</div>

	<button id="singleNewCreateBtn" type="submit" class="btn btn-info">Submit</button>
	<br><br>
</form>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.css">
<div style="display: none;" id="dplayer"></div>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/flv.js/dist/flv.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.js"></script>

@endsection
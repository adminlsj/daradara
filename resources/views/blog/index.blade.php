@extends('layouts.app')

@section('content')
<div class="container mobile-container">
	<div class="row">
		<div class="col-md-8 col-ms-12">
			@include('blog.index-main')
		</div>
		
		<div class="blog-sidebar col-md-4">
			@include('blog.sidebar')
		</div>
	</div>
</div>
@endsection
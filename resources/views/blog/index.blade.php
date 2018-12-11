@extends('layouts.app')

@section('content')
<div class="container mobile-container">
	<div class="row">
		<div class="col-md-8 col-ms-12">
			@include('blog.index-main')
		</div>
		
		<div class="col-xs-12 col-sm-12 col-md-4">
			<div>
		        <h3 style="color: grey; font-weight: 300">日本文化與專題</h3>
		        <hr>
		    </div>
			<div class="sidebar-wrapper col-xs-12">
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div class="ajax-loading"><img src="{{ asset('images/loading.gif') }}" /></div>
			</div>
		</div>
	</div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="padding-setup mobile-container">
	<div class="row" style="padding-top: 6px;">
		<div class="col-md-12">
			<h4 style="color: black; font-weight: 500; margin-bottom: 8px;"><a href="{{ route('blog.search')}}?query={{ $query }}">#{{ $query }}</a> 標籤的影片</h4>
			<div style="margin-left: -10px; margin-right: -10px;" class="video-sidebar-wrapper">
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif"/></div>
			</div>
		</div>
	</div>
</div>
@endsection
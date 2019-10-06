@extends('layouts.app')

@section('content')
<div style="width:78%; margin: 0 auto;" class="mobile-container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 15px;">
			<div>
		        <h3 class="mobile-margin-top" style="color: black; font-weight: 500; margin-top:5px; margin-bottom: 15px;"><a href="{{ route('blog.search')}}?query={{ $query }}">#{{ $query }}</a> 標籤的影片</h3>
		    </div>
			<div class="video-sidebar-wrapper">
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif"/></div>
			</div>
		</div>
	</div>
</div>
@endsection
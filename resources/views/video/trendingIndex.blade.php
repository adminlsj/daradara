@extends('layouts.app')

@section('content')
<div class="padding-setup mobile-container">
	<div class="row">
		<div class="col-md-12" style="margin-top: 32px;">
			<br>
			<div class="video-sidebar-wrapper">
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif"/></div>
			</div>
		</div>
	</div>
</div>
@endsection
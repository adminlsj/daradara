@extends('layouts.app')

@section('content')
<div style="width:78%; margin: 0 auto;" class="mobile-container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 15px;">
			<div class="video-sidebar-wrapper">
				@include('video.singleShowPost')
				<div class="padding-setup" style="font-weight: 400; margin-top:-9px; margin-bottom: 10px; font-size: 1.2em;">相關影片</div>
				<div style="width: 100%; text-align: center; margin-bottom: 10px;">
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- Mobile Horizontal Ads -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:320px;height:100px"
					     data-ad-client="ca-pub-4485968980278243"
					     data-ad-slot="5764379687"></ins>
					<script>
					     (adsbygoogle = window.adsbygoogle || []).push({});
					</script>
			    </div>
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif"/></div>
			</div>
		</div>
	</div>
</div>
@endsection
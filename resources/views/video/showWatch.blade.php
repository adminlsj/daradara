@extends('layouts.app')

@section('content')
<div style="width:78%; margin: 0 auto; background-color:#414141; color: white;" class="mobile-container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 15px;">
			<div class="video-sidebar-wrapper">
				@include('video.singleShowWatch')
				<div class="padding-setup" style="font-weight: 400; margin-top:-9px; margin-bottom: 10px; font-size: 1.2em;">即將播放</div>
				<div style="width: 100%; text-align: center; margin-bottom: 10px;">
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- Horizontal Banner Ads -->
					<ins class="adsbygoogle"
					     style="display:block"
					     data-ad-client="ca-pub-4485968980278243"
					     data-ad-slot="8455082664"
					     data-ad-format="auto"
					     data-full-width-responsive="true"></ins> 
					<script>
					     (adsbygoogle = window.adsbygoogle || []).push({});
					</script>
			    </div>
			    @foreach ($videos as $video)
				    <div style="{{ $video->id == $current_id ? 'background-color: #7A7A7A' : '' }}">
				    	@include('video.singleRelatedPost')
			    	</div>
			    @endforeach
			</div>
		</div>
	</div>
</div>
@endsection
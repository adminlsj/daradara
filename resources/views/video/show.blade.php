@extends('layouts.app')

@section('content')
<div style="width:78%; margin: 0 auto;" class="mobile-container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 15px;">
			<div class="video-sidebar-wrapper">
				@include('video.singleShowPost')
				<iframe width="600" height="445" src="http://video.bilibili.to/m3u8/?w=600&h=445&url=9CA6D9A49F64929D8F937B739FADACA789A2D36FCC977F7F6692B2C3A194C6DA629BD263D5A1C4DEC7A262A8999ACBD26568917DD39D819883CB8891646991996357AA698A76978AA3695877655B9FA65B68A65BAA6A57716589729258759A8775668A759D7A9396909DA3665F9FD4C79BA892A398A66A_m3u8" frameborder="0" border="0" marginwidth="0" marginheight="0" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
				<div class="padding-setup" style="font-weight: 400; margin-top:-9px; margin-bottom: 10px; font-size: 1.2em;">相關影片</div>
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
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif"/></div>
			</div>
		</div>
	</div>
</div>
@endsection
@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5; min-height: calc(100vh - 50px);">
		<div class="paravi-padding-setup" style="margin-top: 10px; margin: 0 auto 0 auto; padding-top: 10px;">
				<h2 style="font-weight: 600">聯絡我們</h2>
				<p>電郵地址：laughseejapan@gmail.com</p>
				<p>官方網站：<a href="https://www.laughseejapan.com">https://www.laughseejapan.com</a></p>
				<a href="/terms">服務條款</a>
				<a href="/policies">社群規範</a>
				<a href="/copyright">版權申訴</a>
		</div>

		<script type="application/ld+json">
		{
		  "@context": "https://schema.org",
		  "@type": "Organization",
		  "url": "http://www.laughseejapan.com",
		  "name": "娛見日本 LaughSeeJapan",
		  "contactPoint": {
		    "@type": "ContactPoint",
		    "email": "laughseejapan@gmail.com",
		    "contactType": "Customer service"
		  }
		}
		</script>
	</div>
</div>
@endsection
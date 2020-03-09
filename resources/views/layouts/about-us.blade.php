@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="padding-setup mobile-container">
	<div class="policy" style="margin-top:40px;">
		<h2 style="font-weight: 600">聯絡我們</h2>
		<p>電郵地址：laughseejapan@gmail.com</p>
		<p>官方網站：<a href="https://www.laughseejapan.com">https://www.laughseejapan.com</a></p>
		<a href="/terms">服務條款</a>
		<a href="/policies">社群規範</a>
		<a href="/copyright">版權申訴</a>
	</div>
	<br><br><br><br><br><br><br>
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
@endsection
@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5;">
		<div class="home-banner-wrapper" style="margin-top: 10px; margin: 0 auto 0 auto; padding-top: 10px;">
			<div style="background-color: white; text-align: left; position: relative;">
				<img src="https://i.imgur.com/X29HWB5.png">
				<div id="home-banner-catchphrase">崁入你的原創內容
一鍵分享給全世界的觀眾</div>

				<div id="home-banner-logo"><span id="english-logo">LaughSeeJapan</span><span id="chinese-logo">娛見日本</span></div>
			</div>
		</div>

		<div style="padding: 0px 30px">
			<p style="font-size: 1.2em; color: #222222; line-height: 28px;">在娛見日本 LaughSeeJapan 上享受您最愛的影片、崁入原創內容，並與全世界觀眾分享您的影片。如此一來，您不僅可以省去跨平台管理影片的麻煩，更可以透過簡單的步驟，一鍵觸及娛見日本 LaughSeeJapan 龐大的用戶群。以下將以影音網站 <a href="https://vimeo.com/" target="_blank">Vimeo</a> 為例，示範在娛見日本 LaughSeeJapan 崁入影片的幾個步驟：</p>
			<h4 style="margin-top: 30px">1. 前往影片的顯示頁面並點選分享影片</h4>
			<img style="width: 100%; max-width: 700px; height: auto" src="https://i.imgur.com/QKVvaM2.png">
			<h4 style="margin-top: 40px">2. 選擇全部並複製崁入影片的代碼</h4>
			<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/Y22rwzL.png">
			<h4 style="margin-top: 40px">3. 點選右上方的上傳影片圖示或用戶主頁的上傳影片按鈕</h4>
			<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/7tmoeUE.png">
			<h4 style="margin-top: 40px">4. 填寫影片的基本資料並將複製的代碼貼上「影片崁入連結」的欄位</h4>
			<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/GMbz8df.png">
			<h4 style="margin-top: 40px">5. 請點選「測試播放」按鈕以確保影片可正常顯示</h4>
			<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/CDqTRdc.png">
			<h4 style="margin-top: 40px">6. 上傳影片並見證影片播放次數的增長！</h4>
			<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/ZJj9SKv.png">

			<h4 style="margin-top: 40px; padding-bottom: 5px;">注意事項：</h4>
			<p style="font-size: 1.2em; color: #222222;">將影片提交至 LaughSeeJapan 即代表您瞭解並同意 LaughSeeJapan 的《<a href="/terms">服務條款</a>》和《<a href="/policies">社群規範</a>》。</p>
			<p style="font-size: 1.2em; color: #222222;">請勿侵犯其他使用者的版權或隱私權，並確保您擁有崁入該影片的權利。 <a href="/copyright">瞭解詳情</a></p>
			<br>
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
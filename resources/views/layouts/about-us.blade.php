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
		<div class="home-banner-wrapper" style="padding-top: 10px;">
			<div style="background-color: white; text-align: left; position: relative;">
				<img src="https://i.imgur.com/X29HWB5.png">
				<div id="home-banner-catchphrase">崁入你的原創內容
一鍵分享給全世界的觀眾</div>

				<div id="home-banner-logo"><span id="english-logo">LaughSeeJapan</span><span id="chinese-logo">娛見日本</span></div>
			</div>
		</div>

		<div style="padding: 0px 30px; margin-top: 30px">
			<p style="font-size: 1.15em; color: #222222; line-height: 28px;">在娛見日本 LaughSeeJapan 上享受您最愛的影片、崁入原創內容，並與全世界觀眾分享您的影片。如此一來，您不僅可以省去跨平台管理影片的麻煩，更可以透過簡單的步驟，一鍵觸及娛見日本 LaughSeeJapan 龐大的用戶群。除了崁入影片之外，您仍可選擇分享及播放您儲存於第三方伺服器的原創影片的鏈結。目前支持播放的影片鏈結的格式包括：MP4、FLV、M3U8。娛見日本 LaughSeeJapan 暫時不支持用戶直接上傳影片，也因此不提供儲存任何影片檔案的服務。以下將以影片串流網站 <a href="https://vimeo.com/" target="_blank">Vimeo</a> 以及影片儲存網站 <a href="https://jwplayer.com/" target="_blank">JWPlayer</a> 為例，分別示範在娛見日本 LaughSeeJapan 崁入影片及影片鏈結的幾個步驟：</p>

			<div class="row" style="margin-top: 20px">
				<div class="col-md-6">
					<div style="border: 1px solid black; padding: 0px 20px">
						<h4 style="margin-top: 25px">崁入影片的步驟：</h4>
						<h4 style="margin-top: 25px">1. 前往影片的顯示頁面並點選分享影片</h4>
						<img style="width: 100%; max-width: 700px; height: auto" src="https://i.imgur.com/QKVvaM2.png">
						<h4 style="margin-top: 40px">2. 選擇全部並複製崁入影片的代碼</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/Y22rwzL.png">
						<h4 style="margin-top: 40px">3. 點選右上方的上傳影片圖示或用戶主頁的上傳影片按鈕</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/Ks2sWEb.png">
						<h4 style="margin-top: 40px; line-height: 25px; margin-bottom: 7px">4. 填寫影片的基本資料並將複製的代碼貼上「影片崁入連結」的欄位。請確保已勾選崁入影片的選項（預設）</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/fgcKOwR.png">
						<h4 style="margin-top: 40px">5. 請點選「測試播放」按鈕以確保影片可正常顯示</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/rxRqQ3r.png">
						<h4 style="margin-top: 40px">6. 上傳影片並見證影片播放次數的增長！</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/26wRkW8.png">
					</div>
				</div>
				<div class="col-md-6">
					<div style="border: 1px solid black; padding: 0px 20px">
						<h4 style="margin-top: 25px">分享影片鏈結的步驟：</h4>
						<h4 style="margin-top: 25px">1. 前往您上傳的影片的顯示頁面</h4>
						<img style="width: 100%; max-width: 700px; height: auto" src="https://i.imgur.com/lprJgJf.png">
						<h4 style="margin-top: 40px">2. 選擇並複製要分享的影片的鏈結</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/PC2pDYv.png">
						<h4 style="margin-top: 40px">3. 點選右上方的上傳影片圖示或用戶主頁的上傳影片按鈕</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/Ks2sWEb.png">
						<h4 style="margin-top: 39px; line-height: 25px; margin-bottom: 7px">4. 填寫影片的基本資料並將複製的影片鏈結貼上「影片崁入連結」的欄位。請確保已取消勾選崁入影片的選項</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/CSVsn5x.png">
						<h4 style="margin-top: 40px">5. 請點選「測試播放」按鈕以確保影片可正常顯示</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/YP3h6HK.png">
						<h4 style="margin-top: 40px">6. 上傳影片並見證影片播放次數的增長！</h4>
						<img style="width: 100%; max-width: 700px;" src="https://i.imgur.com/Vx2Xe7U.png">
					</div>
				</div>
			</div>

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
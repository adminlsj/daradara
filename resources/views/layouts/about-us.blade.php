@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="padding-setup mobile-container">
	<div style="margin-top:7%; text-align: center; font-size: 50px; font-weight: 600">通知刪除說明</div>
	<div class="policy" style="margin-top:40px;">
		<h2 style="font-weight: 600">1）基本聲明</a></h2>
		<p>在為使用者提供高品質視頻體驗的同時，娛見日本LaughSeeJapan 始終非常重視智慧財產權及其他用戶權益的保護。</p>
		<p>由於我們無法對使用者上傳的作品涉及或包含的權利資訊進行甄別，若您認為 娛見日本LaughSeeJapan 網站上的視聽內容侵犯了您的合法權益，請按以下要求提交材料通知。我們將根據權利人提供的資料，遵循相關法律，在審查核實後刪除侵權內容。</p>
		<br>
		<h2 style="font-weight: 600">2）通知刪除指引</a></h2>
		<h4 style="line-height: 35px;">2.1）為了確保通知刪除的有效性，權利人應儘量提供下列材料的原件。不能提供原件的，應在提供的影本上簽章。</h4>
		<p>（1）填寫完整的通知書 （通知書需由權利人或其合法授權的代理人親筆簽名，若為法人，則需加蓋公司大小章）</p>
		<p>（2）權利人主體資訊資料（包括權利人的姓名（名稱）、聯繫方式、位址及營業執照（法人）、身分證（個人）、相關授權證明等證明權利人主體資格的資料）</p>
		<p>（3）構成侵權的初步證明資料</p>
		<p style="padding-left: 15px;">（3.1）權利人應在通知書中寫明請求刪除或斷開的連結的確切名稱、連結位址等資訊。</p>
		<p style="padding-left: 15px;">（3.2）若是智慧財產權侵權，則應提供權利來源的法律文件（包括但不限於有權機構頒發的商標權證書、專利權證書等）及侵權事實的舉證。</p>
		<p style="padding-left: 15px;">（3.3）若是其他權利侵權（名譽權、隱私權等），應提供相應的證明資料。</p>
		<p>（4）權利人保證</p>
		<p style="padding-left: 15px;">（4.1）權利人應當保證其在通知書中的陳述和提供的相關資料都是真實合法的，並保證承擔和賠償因根據權利人的通知書而刪除或者斷開有關侵權內容的連結而給他人造成的任何損失。</p>
		<p>（5）其他資料（若權利人已向相關政府部門或法院提起行政投訴或訴訟的，可將受理證明及其他證據材料一併提交我們，這將有利於權利人的投訴的處理。）</p>

		<h4 style="line-height: 35px;">2.2）請將上述資料以電子郵件寄至我們。</h4>
		<p>電子郵件方式發送至：laughseejapan@gmail.com，請在郵件標題中注明權利人姓名（名稱）和侵權連結名稱。</p>

		<h4 style="line-height: 35px;">2.3）因各種情況不盡相同，在收到權利人的資料後，娛見日本LaughSeeJapan 會在審查核實後儘快處理。</h4>
		<br>
		<h2 style="font-weight: 600">下載表單</a></h2>
		<p>按此下載：<a href="https://pipitv.cc/common/copyright.docx">侵權通知書</a></p>
	</div>
	<div style="margin-top:7%; text-align: center; font-size: 50px; font-weight: 600">娛見日本 LaughSeeJapan</div>
	<div class="policy" style="margin-top:40px;">
		<h2 style="font-weight: 600">聯絡我們</a></h2>
		<p>電郵地址：laughseejapan@gmail.com</p>
		<p>官方網站：<a href="https://www.laughseejapan.com">https://www.laughseejapan.com</a></p>
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
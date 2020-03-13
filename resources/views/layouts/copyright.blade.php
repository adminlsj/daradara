@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
  @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
  @include('layouts.nav-index')
  <div style="background-color: #F5F5F5;">
    <div style="padding-top: 10px" class="hidden-xs hidden-sm"></div>
    <div class="padding-setup">
    	<h4>版權</h4>
    	<p>版權是 LaughSeeJapan 社群成員關注的一大議題。以下內容說明如何在 LaughSeeJapan 上管理權利，以及尊重他人權利的重要性。</p>
    	
		<h5>提交侵權下架通知</h5>
		<p>如果有人在未經授權的情況下，擅自在 LaughSeeJapan 上發布您的版權作品，您可以提交版權侵害通知。在您提出通知前，請務必先考量合理使用、公平處理等原則，或類似的版權特例。請注意，這類要求應由版權擁有者或其授權代理人提出。</p>

		<p>如要提交侵權下架通知，最簡單快速的方法就是填寫我們的網路表單。建議您使用電腦填寫表單，填寫過程會較為輕鬆。</p>

		<p>您輸入的版權擁有者名稱會發布在 LaughSeeJapan 上，取代遭到停用的內容。如果您能提供其他有效且合法的版權擁有者名稱 (例如公司名稱或授權代理人姓名)，我們會進行相關審查，確定沒問題後就會採用該名稱。所有人都能在您的下架要求公開記錄中看到這個名稱和您對疑似侵權作品的描述。您的全名和電子郵件地址等相關資訊也會一併顯示在完整的下架通知中。此外，我們可能也會將這些資訊提供給該部影片的上傳者。</p>

		<p>請注意，選擇提交侵權下架要求即代表您將採取法律途徑。</p>

		<p>填寫以下表單並寄至電子郵箱 laughseejapan@gmail.com，輕鬆向 LaughSeeJapan 檢舉涉嫌侵權的影片。</p>

		<div id="copyright-form" style="border: 1px solid #595959;">
			<h4>侵犯版權通知</h4>
			<hr>
			<h5>問題為何？</h5>
			<p>商標侵權 (有人在使用我的商標) / 侵犯版權 (有人複製我的創作)</p>
			<hr>
			<h5>侵犯版權 - 哪些人會受影響？</h5>
			<p>我本人！ / 我的公司、組織或客戶 / 其他版權擁有者</p>
			<hr>
			<h5>要移除的影片</h5>
			<p>將移除之疑遭侵權影片的 URL：</p>
			<p>描述您認為遭到侵權的作品：</p>
			<hr>
			<h5>您的自我介紹</h5>
			<p>版權擁有者名稱：</p>
			<p>申訴單位：</p>
			<p>主要電子郵件地址：</p>
			<p>我們可能會寄送電子郵件，請您針對下架要求提供其他必要資訊。</p>
			<p>您的法定全名 (姓名，非公司名稱)：</p>
			<p>街名：</p>
			<p>城市：</p>
			<p>州 / 省：</p>
			<p>郵遞區號：</p>
			<p>國家 / 地區：</p>
			<p>行動電話：</p>
			<hr>
			<h5>提交該表格，即表示本人願意以個人誠信擔保，以下聲明一切屬實：</h5>
			<p>1. 本人為疑似遭到侵權的專屬權利擁有者，或是其所授權的代理人。</p>
			<p>2. 本人確信申訴中有爭議資料的使用未經版權擁有者、其代理人或法律授權；並且</p>
			<p>3. 此通知正確無誤。</p>
			<p>4. 本人瞭解，若使用此程序蓄意提出不實侵權主張，可能必須面臨對本人不利之法律後果。</p>
			<p>5. 我瞭解若濫用此工具將會導致終止我的 LaughSeeJapan 帳戶。</p>
			<hr>
			<h4>簽署：</h4>
		</div>
		
		<br>
    </div>
</div>
@endsection
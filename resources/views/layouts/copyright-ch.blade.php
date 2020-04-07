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
    <div class="paravi-padding-setup" style="margin: 0 auto 0 auto; padding-top: 10px; padding-bottom: 10px;">
    	<form action="{{ route('email.copyrightReport') }}" method="GET">
	    	<h4>版權
		      <div style="margin-top:-5px; font-weight: 400 !important;" class="pull-right">
			    <select name="forma" onchange="location = this.value;">
			     <option value="#">選擇語言...</option>
				 <option value="#">中文</option>
				 <option value="/copyright?lang=en">English</option>
				</select>
			  </div>
			</h4>

	    	<p>版權是 LaughSeeJapan 社群成員關注的一大議題。以下內容說明如何在 LaughSeeJapan 上管理權利，以及尊重他人權利的重要性。</p>
	    	
			<h5>提交侵權下架通知</h5>
			<p>如果有人在未經授權的情況下，擅自在 LaughSeeJapan 上發布您的版權作品，您可以提交版權侵害通知。在您提出通知前，請務必先考量合理使用、公平處理等原則，或類似的版權特例。請注意，這類要求應由版權擁有者或其授權代理人提出。</p>

			<p>如要提交侵權下架通知，最簡單快速的方法就是填寫我們的網路表單。建議您使用電腦填寫表單，填寫過程會較為輕鬆。我們也接受形式不拘的版權侵害通知；透過電子郵件、傳真及郵寄方式均可提交。</p>

			<p>您輸入的版權擁有者名稱會發布在 LaughSeeJapan 上，取代遭到停用的內容。如果您能提供其他有效且合法的版權擁有者名稱 (例如公司名稱或授權代理人姓名)，我們會進行相關審查，確定沒問題後就會採用該名稱。所有人都能在您的下架要求公開記錄中看到這個名稱和您對疑似侵權作品的描述。您的全名和電子郵件地址等相關資訊也會一併顯示在完整的下架通知中。此外，我們可能也會將這些資訊提供給該部影片的上傳者。</p>

			<p>請注意，選擇提交侵權下架要求即代表您將採取法律途徑。</p>

			<div id="copyright-form" style="border: 1px solid #595959; margin-top: 15px">
				<h4>侵犯版權通知</h4>

				<hr>

				<h5 style="font-weight: 600">問題為何？</h5>
				<div style="padding: 0px 10px 5px 10px;">
					<div>
					  <input type="radio" name="copyrightReason" id="logo" value="商標侵權 (有人在使用我的商標)" required>
					  <label for="logo" style="font-weight: 400">
					    &nbsp;商標侵權 (有人在使用我的商標)
					  </label>
					</div>
					<div>
					  <input type="radio" name="copyrightReason" id="copyright" value="侵犯版權 (有人複製我的創作)" required>
					  <label for="copyright" style="font-weight: 400">
					    &nbsp;侵犯版權 (有人複製我的創作)
					  </label>
					</div>
					<div>
					  <input type="radio" name="copyrightReason" id="others" value="其他法律問題" required>
					  <label for="others" style="font-weight: 400">
					    &nbsp;其他法律問題
					  </label>
					</div>
				</div>

				<hr>

				<h5 style="font-weight: 600">侵犯版權 - 哪些人會受影響？</h5>
				<div style="padding: 0px 10px 5px 10px;">
					<div>
					  <input type="radio" name="copyrightStakeholders" id="individual" value="我本人！" required>
					  <label for="individual" style="font-weight: 400">
					    &nbsp;我本人！
					  </label>
					</div>
					<div>
					  <input type="radio" name="copyrightStakeholders" id="company" value="我的公司、組織或客戶" required>
					  <label for="company" style="font-weight: 400">
					    &nbsp;我的公司、組織或客戶
					  </label>
					</div>
					<div>
					  <input type="radio" name="copyrightStakeholders" id="thirdparty" value="其他版權擁有者" required>
					  <label for="thirdparty" style="font-weight: 400">
					    &nbsp;其他版權擁有者
					  </label>
					</div>
				</div>

				<hr>

				<h5 style="font-weight: 600">要移除的影片</h5>
				<p style="margin-bottom: 3px">將移除之疑遭侵權影片的 URL：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightURL" id="copyrightURL" required>
				</div>
				<p style="margin-bottom: 3px">描述您認為遭到侵權的作品：</p>
				<div style="padding: 0px 10px 10px 10px;">
			      <select name="copyrightSelect" id="copyrightSelect" class="form-control" required>
			        <option value="">請選取其中一項...</option>
			        <option value="其他使用者重複上傳了我的公司、組織或客戶的 LaughSeeJapan 影片">其他使用者重複上傳了我的公司、組織或客戶的 LaughSeeJapan 影片</option>
			        <option value="我的公司、組織或客戶的名稱">我的公司、組織或客戶的名稱</option>
			        <option value="我的公司、組織或客戶的原創歌曲">我的公司、組織或客戶的原創歌曲</option>
			        <option value="我的公司、組織或客戶的軟體">我的公司、組織或客戶的軟體</option>
			        <option value="我的公司、組織或客戶的作品">我的公司、組織或客戶的作品</option>
			        <option value="我的公司、組織或客戶的現場表演內容">我的公司、組織或客戶的現場表演內容</option>
			        <option value="我的公司、組織或客戶的影片 (非 LaughSeeJapan 影片)">我的公司、組織或客戶的影片 (非 LaughSeeJapan 影片)</option>
			        <option value="我的公司、組織或客戶的版權標誌">我的公司、組織或客戶的版權標誌</option>
			        <option value="其他">其他</option>
			      </select>
			    </div>

				<hr>

				<h5 style="font-weight: 600">您的自我介紹</h5>
				<p style="margin-bottom: 3px">版權擁有者名稱 (公司名稱)：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightCompanyName" id="copyrightCompanyName" required>
				  <small style="padding: 0px; margin-bottom: 0px">版權擁有者的名稱會取代遭下架的內容，公開顯示在 LaughSeeJapan 網站上。所有人都能在您的下架要求記錄 (公開的記錄) 和疑似侵權的作品說明中看到這個名稱。您的法定全名和電子郵件地址等相關資訊也會一併顯示在完整的下架通知內文中。此外，我們也可能會將這些資訊提供給影片的上傳者。</small>
				</div>
				<p style="margin-bottom: 3px">您的頭銜或職稱 (您提出此投訴的權限為何)：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserOccupation" id="copyrightUserOccupation" required>
				</div>
				<p style="margin-bottom: 3px">主要電子郵件地址：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserEmail" id="copyrightUserEmail" required>
				  <small style="padding: 0px; margin-bottom: 0px">我們可能會寄送電子郵件，請您針對下架要求提供其他必要資訊。</small>
				</div>
				<p style="margin-bottom: 3px">您的法定全名 (姓名，非公司名稱)：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserName" id="copyrightUserName" required>
				</div>
				<p style="margin-bottom: 3px">街名：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserStreet" id="copyrightUserStreet" required>
				</div>
				<p style="margin-bottom: 3px">城市：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserCity" id="copyrightUserCity" required>
				</div>
				<p style="margin-bottom: 3px">州 / 省：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserRegion" id="copyrightUserRegion" required>
				</div>
				<p style="margin-bottom: 3px">郵遞區號：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserCode" id="copyrightUserCode" required>
				</div>
				<p style="margin-bottom: 3px">國家 / 地區：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserCountry" id="copyrightUserCountry" required>
				</div>
				<p style="margin-bottom: 3px">行動電話：</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserMobile" id="copyrightUserMobile" required>
				</div>

				<hr>

				<h5 style="font-weight: 600">勾選下列方塊，即表示本人願意以個人誠信擔保，以下聲明一切屬實：</h5>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmAuthorized" id="copyrightConfirmAuthorized" value="本人為疑似遭到侵權的專屬權利擁有者，或是其所授權的代理人。" required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmAuthorized">&nbsp;本人為疑似遭到侵權的專屬權利擁有者，或是其所授權的代理人。</label>
					</div>
				</div>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmSensible" id="copyrightConfirmSensible" value="本人確信申訴中有爭議資料的使用未經版權擁有者、其代理人或法律授權；並且" required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmSensible">&nbsp;本人確信申訴中有爭議資料的使用未經版權擁有者、其代理人或法律授權；並且</label>
					</div>
				</div>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmCorrect" id="copyrightConfirmCorrect" value="此通知正確無誤。" required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmCorrect">&nbsp;此通知正確無誤。</label>
					</div>
				</div>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmAcknowledge" id="copyrightConfirmAcknowledge" value="本人瞭解，若使用此程序蓄意提出不實侵權主張，可能必須面臨對本人不利之法律後果。" required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmAcknowledge">&nbsp;本人瞭解，若使用此程序蓄意提出不實侵權主張，可能必須面臨對本人不利之法律後果。</label>
					</div>
				</div>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmTerminate" id="copyrightConfirmTerminate" value="我瞭解若濫用此工具將會導致終止我的 LaughSeeJapan 帳戶。" required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmTerminate">&nbsp;我瞭解若濫用此工具將會導致終止我的 LaughSeeJapan 帳戶。</label>
					</div>
				</div>

				<hr>

				<h5 style="font-weight: 600">在此方塊內輸入您的全名，以做為您的數位簽章：</h5>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserSignature" id="copyrightUserSignature" required>
				</div>

				<button type="submit" style="margin: 0px 10px 10px 10px; width: auto; border: 0px; font-weight: 500; font-size: 1em; padding: 7px 10px" class="btn btn-primary" name="submit">提交申訴</button>
			</div>
		</form>
		<br>
    </div>
</div>
@endsection
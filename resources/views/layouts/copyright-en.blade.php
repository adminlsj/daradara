@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-xs hidden-sm hidden-md sidebar-menu">
  @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
  <div style="background-color: #F5F5F5;">
    <div class="paravi-padding-setup" style="margin: 0 auto 0 auto; padding-top: 10px; padding-bottom: 10px;">
    	<form action="{{ route('email.copyrightReport') }}" method="GET">
	    	<h4>Copyright
		      <!-- <div style="margin-top:-3px; font-weight: 400 !important;" class="pull-right">
			    <select name="forma" onchange="location = this.value;">
			     <option value="#">Languages...</option>
				 <option value="/copyright?lang=ch">中文</option>
				 <option value="#">English</option>
				</select>
			  </div> -->
			</h4>
	    	<p>Copyright is an important topic for the LaughSeeJapan community. This LaughSeeJapan Copyright Policy is a part of LaughSeeJapan’s Terms of Service and sets forth the process by which copyright holders and their agents may remove allegedly infringing materials available on one of LaughSeeJapan’s online services. Below, you can find out how to manage your rights on LaughSeeJapan and learn more about respecting the rights of others.</p>
	    	
			<h5>1. DMCA Policy</h5>
			<p>LaughSeeJapan respects the intellectual property of others and expects its users to do the same. Each user must ensure that the materials they upload do not infringe any third-party copyright. LaughSeeJapan will promptly remove materials in accordance with the Digital Millennium Copyright Act (“DMCA”) when properly notified that the materials infringe a third party's copyright. LaughSeeJapan will also, in appropriate circumstances, terminate the accounts of repeat copyright infringers.In filing any request, please ensure that your notice is complete and that your statements are accurate. If we request additional information necessary to make your notice complete, please provide that information promptly. If you fail to provide the required information, your request may not be processed further. For non-copyright complaints, please see our Trademark Infringement Complaint Form or our Privacy Complaint Form.</p>

			<h5>2. DMCA Takedown Notices</h5>
			<p style="white-space: pre-line;">To request the removal of materials based upon copyright infringement, you must file a notice containing the following:
1. Your name, address, telephone number, and email address (if any).
2. A description of the copyrighted work that you claim has been infringed.
3. A description of where on LaughSeeJapan’s service the material that you claim is infringing may be found, sufficient for LaughSeeJapan to locate the material (e.g., the URL for the video).
4. A statement that you have a good faith belief that the use of the copyrighted work is not authorized by the copyright owner, its agent, or the law.
5. A statement by you UNDER PENALTY OF PERJURY that the information in your notice is accurate and that you are the copyright owner or authorized to act on the copyright owner's behalf.
6. Your electronic or physical signature.</p>
<p style="white-space: pre-line;">You may file your notice:
- By email: laughseejapan@freemail.hu</p>
<p>LaughSeeJapan may disclose notices with affected users and third-party databases that collect information about copyright takedown notices.</p>

			<h5>3. DMCA Counter-Notifications</h5>
			<p style="white-space: pre-line;">If you are a LaughSeeJapan user who wishes to challenge the removal of materials caused by a DMCA takedown notice, you must file a counter-notification containing the following:
1. Your name, address, and telephone number.
2. A description of the material that was removed and the location on LaughSeeJapan’s service where it previously appeared (e.g., the URL of the video).
3. A statement UNDER PENALTY OF PERJURY that you have a good faith belief that the material was removed or disabled as a result of mistake or misidentification.
4. A statement that you consent to the jurisdiction of the Federal District Court for the judicial district in which your address is located, or if your address is outside of the United States, any judicial district in which LaughSeeJapan may be found (the United States District Court for the Southern District of New York), and that you will accept service of process from the person who filed the original DMCA notice or an agent of that person.
5. Your electronic or physical signature.</p>
<p style="white-space: pre-line;">You may submit this notice:
- By email: laughseejapan@freemail.hu</p>
<p>LaughSeeJapan will forward any complete counter-notification to the person who filed the original DMCA notice. The copyright owner(s) may elect to file a lawsuit against you for copyright infringement. If we do not receive notice that such a lawsuit has been filed within ten (10) business days after we provide notice of your counter-notification, we may restore the challenged materials. Until that time, your materials will remain removed.</p>

			<h5>4. Repeat Infringers</h5>
			<p>LaughSeeJapan will terminate user accounts that receive three (3) DMCA strikes. A “DMCA strike” accrues each time that material is removed from a user’s account due to a DMCA notice. We may group multiple DMCA notices received within a short period of time as a single DMCA strike.

We may remove a DMCA strike in appropriate circumstances, such as where (1) the underlying material is ultimately restored due to a DMCA counter-notification; or (2) the claimant withdraws the underlying notice.

We may terminate user accounts that receive fewer than three (3) DMCA strikes in appropriate circumstances, such as where the user has a history of violating or willfully disregarding our Terms of Service.</p>

			<p>If you choose to submit a copyright takedown request, remember that you're starting a legal process.</p>
		<br>
    </div>
</div>
@endsection
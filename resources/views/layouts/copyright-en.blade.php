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
	    	<h4>Copyright
		      <div style="margin-top:-3px; font-weight: 400 !important;" class="pull-right">
			    <select name="forma" onchange="location = this.value;">
			     <option value="#">Languages...</option>
				 <option value="/copyright?lang=ch">中文</option>
				 <option value="#">English</option>
				</select>
			  </div>
			</h4>
	    	<p>Copyright is an important topic for the LaughSeeJapan community. Below, you can find out how to manage your rights on LaughSeeJapan and learn more about respecting the rights of others.</p>
	    	
			<h5>Submit a copyright takedown notice</h5>
			<p>If your copyright-protected work was posted on LaughSeeJapan without authorization, you may submit a copyright infringement notification. Be sure to consider whether fair use, fair dealing, or a similar exception to copyright applies before you submit. These requests should be sent by the copyright owner or an agent authorized to act on the owner’s behalf.</p>

			<p>The fastest and simplest way to submit a copyright takedown notice is through our webform. We recommend using a computer for the easiest method. We will also accept free-form copyright infringement notifications, submitted by email, fax, and mail.</p>

			<p>The name you enter as copyright owner will be published on LaughSeeJapan in place of the turned off content. If you can give us a valid legal alternative, such as a company name or the name of an authorized representative, we'll review and apply it if appropriate. The name will become part of the public record of your request, along with your description of the work(s) allegedly infringed. All other information, including your full legal name and email, are part of the full takedown notice, which may be given to the uploader.</p>

			<p>If you choose to submit a copyright takedown request, remember that you're starting a legal process.</p>

			<div id="copyright-form" style="border: 1px solid #595959; margin-top: 15px">
				<h4>Copyright Infringement Notification</h4>

				<hr>

				<h5 style="font-weight: 600">What is the issue?</h5>
				<div style="padding: 0px 10px 5px 10px;">
					<div>
					  <input type="radio" name="copyrightReason" id="logo" value="Trademark infringement (Someone is using my trademark)" required>
					  <label for="logo" style="font-weight: 400">
					    &nbsp;Trademark infringement (Someone is using my trademark)
					  </label>
					</div>
					<div>
					  <input type="radio" name="copyrightReason" id="copyright" value="Copyright infringement (Someone copied my creation)" required>
					  <label for="copyright" style="font-weight: 400">
					    &nbsp;Copyright infringement (Someone copied my creation)
					  </label>
					</div>
					<div>
					  <input type="radio" name="copyrightReason" id="others" value="Other legal issue" required>
					  <label for="others" style="font-weight: 400">
					    &nbsp;Other legal issue
					  </label>
					</div>
				</div>

				<hr>

				<h5 style="font-weight: 600">Copyright infringement - Who is affected?</h5>
				<div style="padding: 0px 10px 5px 10px;">
					<div>
					  <input type="radio" name="copyrightStakeholders" id="individual" value="I am!" required>
					  <label for="individual" style="font-weight: 400">
					    &nbsp;I am!
					  </label>
					</div>
					<div>
					  <input type="radio" name="copyrightStakeholders" id="company" value="My company, organization, or client" required>
					  <label for="company" style="font-weight: 400">
					    &nbsp;My company, organization, or client
					  </label>
					</div>
					<div>
					  <input type="radio" name="copyrightStakeholders" id="thirdparty" value="Another copyright owner" required>
					  <label for="thirdparty" style="font-weight: 400">
					    &nbsp;Another copyright owner
					  </label>
					</div>
				</div>

				<hr>

				<h5 style="font-weight: 600">Videos to be removed</h5>
				<p style="margin-bottom: 3px">URL of allegedly infringing video to be removed:</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightURL" id="copyrightURL" required>
				</div>
				<p style="margin-bottom: 3px">Describe the work allegedly infringed:</p>
				<div style="padding: 0px 10px 10px 10px;">
			      <select name="copyrightSelect" id="copyrightSelect" class="form-control" required>
			        <option value="">Please select one...</option>
			        <option value="My company, organization, or client's LaughSeeJapan video was reuploaded by another user">My company, organization, or client's LaughSeeJapan video was reuploaded by another user</option>
			        <option value="My company, organization, or client's name">My company, organization, or client's name</option>
			        <option value="My company, organization, or client's original song">My company, organization, or client's original song</option>
			        <option value="My company, organization, or client's software">My company, organization, or client's software</option>
			        <option value="My company, organization, or client's artwork">My company, organization, or client's artwork</option>
			        <option value="My company, organization, or client's live performance">My company, organization, or client's live performance</option>
			        <option value="My company, organization, or client's video (not from LaughSeeJapan)">My company, organization, or client's video (not from LaughSeeJapan)</option>
			        <option value="My company, organization, or client's copyrighted logo">My company, organization, or client's copyrighted logo</option>
			        <option value="Other">Other</option>
			      </select>
			    </div>

				<hr>

				<h5 style="font-weight: 600">Tell us about yourself</h5>
				<p style="margin-bottom: 3px">Copyright Owner Name (Company Name):</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightCompanyName" id="copyrightCompanyName" required>
				  <small style="padding: 0px; margin-bottom: 0px">The copyright owner name will be published on LaughSeeJapan in place of disabled content. This will become part of the public record of your request, along with your description(s) of the work(s) allegedly infringed. All other information, including your full legal name and email address, are part of the full takedown notice, which may be provided to the uploader.</small>
				</div>
				<p style="margin-bottom: 3px">Your Title or Job Position (What is your authority to make this complaint?):</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserOccupation" id="copyrightUserOccupation" required>
				</div>
				<p style="margin-bottom: 3px">Primary Email Address:</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserEmail" id="copyrightUserEmail" required>
				  <small style="padding: 0px; margin-bottom: 0px">We may email you about your takedown request if additional information is required. You may wish to provide an alternative email address where we can reach you, for example, if you don't frequently check the email address associated with your account.</small>
				</div>
				<p style="margin-bottom: 3px">Your Full Legal Name (A first and a last name, not a company name):</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserName" id="copyrightUserName" required>
				</div>
				<p style="margin-bottom: 3px">Street Address:</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserStreet" id="copyrightUserStreet" required>
				</div>
				<p style="margin-bottom: 3px">City:</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserCity" id="copyrightUserCity" required>
				</div>
				<p style="margin-bottom: 3px">State/Province:</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserRegion" id="copyrightUserRegion" required>
				</div>
				<p style="margin-bottom: 3px">ZIP/Postal Code:</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserCode" id="copyrightUserCode" required>
				</div>
				<p style="margin-bottom: 3px">Country:</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserCountry" id="copyrightUserCountry" required>
				</div>
				<p style="margin-bottom: 3px">Phone:</p>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserMobile" id="copyrightUserMobile" required>
				</div>

				<hr>

				<h5 style="font-weight: 600">By checking the following boxes, I, in good faith, state that:</h5>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmAuthorized" id="copyrightConfirmAuthorized" value="I am the owner, or an agent authorized to act on behalf of the owner of an exclusive right that is allegedly infringed." required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmAuthorized">&nbsp;I am the owner, or an agent authorized to act on behalf of the owner of an exclusive right that is allegedly infringed.</label>
					</div>
				</div>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmSensible" id="copyrightConfirmSensible" value="I have a good faith belief that the use of the material in the manner complained of is not authorized by the copyright owner, its agent, or the law; and" required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmSensible">&nbsp;I have a good faith belief that the use of the material in the manner complained of is not authorized by the copyright owner, its agent, or the law; and</label>
					</div>
				</div>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmCorrect" id="copyrightConfirmCorrect" value="This notification is accurate." required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmCorrect">&nbsp;This notification is accurate.</label>
					</div>
				</div>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmAcknowledge" id="copyrightConfirmAcknowledge" value="I acknowledge that there may be adverse legal consequences for making false or bad faith allegations of copyright infringement by using this process." required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmAcknowledge">&nbsp;I acknowledge that there may be adverse legal consequences for making false or bad faith allegations of copyright infringement by using this process.</label>
					</div>
				</div>
				<div style="padding: 0px 10px 5px 10px;">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox" name="copyrightConfirmTerminate" id="copyrightConfirmTerminate" value="I understand that abuse of this tool will result in termination of my LaughSeeJapan account." required>
					  <label style="font-weight: 400" class="form-check-label" for="copyrightConfirmTerminate">&nbsp;I understand that abuse of this tool will result in termination of my LaughSeeJapan account.</label>
					</div>
				</div>

				<hr>

				<h5 style="font-weight: 600">Typing your full name in this box will act as your digital signature.</h5>
				<div style="padding: 0px 10px 10px 10px;">
				  <input type="text" class="form-control" name="copyrightUserSignature" id="copyrightUserSignature" required>
				</div>

				<button type="submit" style="margin: 0px 10px 10px 10px; width: auto; border: 0px; font-weight: 500; font-size: 1em; padding: 7px 10px" class="btn btn-primary" name="submit">Submit Complaint</button>
			</div>
		</form>
		<br>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('nav')
	@include('nav.main')
@endsection

@section('content')
	<div id="loginModal" class="list-rows-wrapper" style="padding: 0 4%; color: white;">
		<h4 style="font-size: 1.7em;">成為 Hanime1 的創作者</h4>
		<div style="font-size: 1.1em;">
			<span style="font-weight: 500;">在 <span style="font-weight: bold">Hanime1.me</span> 上享受最愛的影片、崁入原創內容，並與全世界觀眾分享您的影片。</span>
			<form action="{{ route('email.userReport') }}" method="GET">
				<input type="hidden" id="video-id" name="video-id" value="{{ Auth::user()->id }}">
		        <input type="hidden" id="video-title" name="video-title" value="User Verification">
		        <input type="hidden" id="video-sd" name="video-sd" value="User Verification">
		        <input type="hidden" id="report-email" name="report-email" value="{{ Auth::user()->email }}">
		        <input style="display: none" type="radio" name="userReportReason" id="others" value="其他原因" required checked>
				<div style="margin-top: 20px;" class="form-check">
					<div style="line-height: 40px;">請問您將上傳什麼類型的內容？</div>
                    <input style="color: black" type="text" class="form-control-plaintext" name="others-text" id="others-text" value="" required>
				</div>
				<div style="margin-top: 15px;">
					<button type="submit" style="width: auto; background-color: #d84b6b; border: 0px; color: white; font-weight: 400; font-size: 1.1em;" class="btn btn-primary" name="submit">提交</button>
				</div>
			</form>
		</div>
	</div>
@endsection
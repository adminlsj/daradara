@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div id="signUpModal" class="list-rows-wrapper" style="padding: 0 4%; color: white;">

	<form method="POST" action="{{ route('user.update', $user) }}" enctype="multipart/form-data">
	    {{ csrf_field() }}
	    {{ method_field('patch') }}

	    <input type="hidden" id="type" name="type" value="photo">

		<img style="width: 70px; border-radius: 50%; margin-right: 20px" src="{{ $user->avatar_temp }}">
		<div style="display: inline-block; vertical-align: middle;">
			<h5 style="font-size: 20px;">{{ $user->name }}</h5>
			<h5 id="label" style="font-size: 15px; color: red; cursor: pointer; font-weight: bold" onclick="document.getElementById('photo').click()">更換個人頭像</h5>
			<input style="display: none;" type="file" name="photo" id="photo" accept="image/*" required onchange="this.form.submit(); this.disabled=true; document.getElementById('label').innerHTML='更換頭像中...';">
		</div>
	</form>

	<hr style="margin-left: -4%; margin-right: -4%; border-color: #333333; margin-top: 30px; margin-bottom: 30px;">

    <form method="POST" action="{{ route('user.update', $user) }}">
	    {{ csrf_field() }}
	    {{ method_field('patch') }}

	    <input type="hidden" id="type" name="type" value="profile">

	    <h4 style="font-size: 1.7em">編輯個人檔案</h4>
		<div style="font-size: 1.1em">
			<span style="font-weight: 500;">編輯你在 <span style="font-weight: bold">Hanime1.me</span> 上顯示的用戶名稱以及登入時使用的電郵地址。</span>
			<div class="form-group" style="margin-top: 20px;">
				<input style="background-color: #131313; color: white;" type="text" class="form-control" name="name" id="name" placeholder="用戶名稱" value="{{ $user->name }}" required>
			</div>
			<div class="form-group">
				<input style="background-color: #131313; color: white;" type="email" class="form-control" name="email" id="email" placeholder="電郵地址" value="{{ $user->email }}" required>
			</div>
			<button style="height: 45px; margin-top: 10px; font-size: 1em; background-color: red !important; border-color: red !important;" type="submit" class="btn btn-info" name="submit">更新個人檔案</button>
		</div>
	</form>

	<hr style="margin-left: -4%; margin-right: -4%; border-color: #333333; margin-top: 35px; margin-bottom: -30px;">

	<form style="margin-top: 60px; margin-bottom: 78px" method="POST" action="{{ route('user.update', $user) }}">
	    {{ csrf_field() }}
	    {{ method_field('patch') }}

	    <input type="hidden" id="type" name="type" value="password">

	    <h4 style="font-size: 1.7em">更改密碼</h4>
		<div style="font-size: 1.1em">
			<span style="font-weight: 500;">更改你在 <span style="font-weight: bold">Hanime1.me</span> 上登入時輸入的密碼，或點擊忘記密碼重新設定。</span>
			<div class="form-group" style="margin-top: 20px;">
				<input style="background-color: #131313; color: white;" type="password" class="form-control" name="password_old" id="password_old" placeholder="舊密碼" required>
			</div>
			<div class="form-group" style="margin-top: 20px;">
				<input style="background-color: #131313; color: white;" type="password" class="form-control" name="password_new" id="password_new" placeholder="新密碼" required>
			</div>
			<div class="form-group" style="margin-top: 20px;">
				<input style="background-color: #131313; color: white;" type="password" class="form-control" name="password_new_confirm" id="password_new_confirm" placeholder="確認新密碼" required>
			</div>
			<div style="margin-top: 20px; margin-bottom: 20px; font-size: 0.95em">
	            <a href="/password/reset" target="_blank" style="cursor: pointer; text-decoration: none; font-weight: 500;">忘記密碼？</a>
            </div>
			<button style="height: 45px; margin-top: 10px; font-size: 1em; background-color: red !important; border-color: red !important;" type="submit" class="btn btn-info" name="submit">更改密碼</button>
		</div>
	</form>
</div>

@include('layouts.nav-bottom')

@endsection
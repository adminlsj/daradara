@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div class="content-padding-new list-rows-wrapper">
    <h3 style="color:white">編輯個人檔案</h3>

    <form method="POST" action="{{ route('user.update', $user) }}">
	    {{ csrf_field() }}
	    {{ method_field('patch') }}

	    <input type="hidden" id="type" name="type" value="profile">

	    <div class="form-group" style="margin-top: 20px;">
	    	<div style="color: white; display: inline-block; width: 100px;">用戶名稱</div>
			<input style="background-color: #333333; color: white; border-color: #333333; display: inline-block; width: 350px" type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
		</div>

		<div class="form-group" style="margin-top: 10px;">
			<div style="color: white; display: inline-block; width: 100px;">電郵地址</div>
			<input style="background-color: #333333; color: white; border-color: #333333; display: inline-block; width: 350px" type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
		</div>

	    <button style="margin-left: 104px;" type="submit">提交</button>
	</form>

	<h3 style="color:white; margin-top: 50px;">更改密碼</h3>

	<form method="POST" action="{{ route('user.update', $user) }}">
	    {{ csrf_field() }}
	    {{ method_field('patch') }}

	    <input type="hidden" id="type" name="type" value="password">

		<div class="form-group" style="margin-top: 20px;">
			<div style="color: white; display: inline-block; width: 100px;">舊密碼</div>
			<input style="background-color: #333333; color: white; border-color: #333333; display: inline-block; width: 350px" type="password" class="form-control" name="password_old" id="password_old">
		</div>

		<div class="form-group" style="margin-top: 10px;">
			<div style="color: white; display: inline-block; width: 100px;">新密碼</div>
			<input style="background-color: #333333; color: white; border-color: #333333; display: inline-block; width: 350px" type="password" class="form-control" name="password_new" id="password_new">
		</div>

		<div class="form-group" style="margin-top: 10px;">
			<div style="color: white; display: inline-block; width: 100px;">確認新密碼</div>
			<input style="background-color: #333333; color: white; border-color: #333333; display: inline-block; width: 350px" type="password" class="form-control" name="password_new_confirm" id="password_new_confirm">
		</div>

	    <button style="margin-left: 104px;" type="submit">更改</button>
	</form>

	<div style="margin-left: 103px; margin-top: 20px; margin-bottom: 20px;">
		<a href="/password/reset" target="_blank" style="cursor: pointer; text-decoration: none; font-weight: 500;">忘記密碼？</a>
	</div>
</div>

@include('layouts.nav-bottom')

@endsection
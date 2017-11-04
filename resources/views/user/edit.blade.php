@extends('layouts.app')

@section('content')
    @include('layouts.error')
	<div class="container">
        <div class="row">
	        <div class="col-md-12">
	            <h3 style="color: grey; font-weight: 300">帳戶設定</h3>
	            <hr>
	        </div>
	    </div>
	    <br>
	    <div class="row">
	        <div class="col-md-8">
			    <form class="order-form" action="{{ route('user.update', ['user' => Auth::user()->id]) }}" method="POST">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<div class="row">
						<div class="col-md-5">
						    <input type="text" value="{{ old( 'name', $user->name) }}" id="name" name="name">
						</div>
						<div class="col-md-7">
						    <input name="email" type="text" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old( 'email', $user->email) }}">
						</div>
					</div>

					<div class="row">
					    <div class="col-md-12">
						    <input type="text" id="description" name="description" rows="4" placeholder="關於你" value="{{ old( 'description', $user->description) }}">
					    </div>
					</div>

					<div class="row">
					    <div class="col-md-12">
						    <input style="margin-bottom: 2px" type="text" value="{{ old('password', $user->bank_account) }}" id="bank_account" name="bank_account" placeholder="收款帳號">
						    <small style="padding-left: 4px; color: grey;" id="gameAccountHelp">您的收款帳號只會在完成交易後用作接收我們的匯款，並不會透露給任何第三者</small>
					    </div>
					</div>

					<hr style="margin-top: 55px;">

					<div class="form-group row">
					    <label for="password" class="col-md-2 text-center"><h5>密碼</h5></label>
					    <div class="col-md-10">
							<input name="password" type="password" value="{{ old('password', $user->password) }}" id="password">
					    </div>
					</div>

					<div class="form-group row">
					  <label for="password_confirmation" class="col-md-2 text-center"><h5>密碼確認</h5></label>
					  <div class="col-md-10">
					    <input name="password_confirmation" type="password" value="{{ old( 'password', $user->password) }}" id="password_confirmation">
					  </div>
					</div>

					<div class="col-md-8 col-md-offset-2">
						<button type="submit" class="btn btn-info btn-outline btn-lg btn-block">更新帳戶資料</button>
						<br>
					</div>
				</form>
	        </div>

	        <br class="visible-xs-block">
	        <br class="visible-xs-block">
	        
	        <div class="col-md-4" style="padding-left: 30px">
			    <form id="avatar-form" method="POST" action="{{ url('users/'.Auth::user()->id.'/storeAvatar') }}" enctype="multipart/form-data">
			    	{{ csrf_field() }}
			    	<label for="avatar-upload" class="btn btn-info" style="border-radius: 2px !important; padding:0; border-bottom-width: 0; border-left-width: 0; border-right-width: 0;">
					    <h5 style="line-height: 15px"><i class="fa fa-cloud-upload"></i>&nbsp;更新個人頭像</h5>
				        <img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/originals/{{ $user->avatar->filename }}.jpg" class="img-responsive" style="border-bottom-left-radius: 2px; border-bottom-right-radius: 2px">
					</label>
			    	<input id="avatar-upload" type="file" name="avatar"></input>
			    </form>
			    <br>
		    </div>
		</div>
    </div>
    <br>
@endsection
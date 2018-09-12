@extends('layouts.app')

@section('content')
<div style="width: 90%" class="container">
	<div style="margin-top: 40px;">
		<h3 style="color: grey; font-weight: 300">聯絡我們</h3>
		<hr>
	</div>
	<form class="job-form" action="/sendMail/contact" method="POST">
		{{ csrf_field() }}
		<div class="row">
		    <div class="col-md-12">
			    <input placeholder="您的電郵" type="text" value="" id="email" name="email" required>
		    </div>
		</div>

		<div class="row">
		    <div class="col-md-12">
			    <input placeholder="標題" type="text" value="" id="title" name="title">
		    </div>
		</div>

		<div class="row">
		    <div class="col-md-12">
			    <input placeholder="內容" type="text" value="" id="text" name="text" required>
		    </div>
		</div>

		<div class="row">
			<div class="col-xs-6 col-xs-offset-3">
				<br>
				<button type="submit" class="btn btn-info btn-outline btn-lg btn-block">Send</button>
			</div>
		</div>
	</form>
</div>
<br><br><br><br><br>
@endsection
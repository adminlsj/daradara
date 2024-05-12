@extends('layouts.app')

@section('nav')
	@include('nav.md')
@endsection

@section('content')

<div style="position: relative; margin-top: 0px; padding-top: 100px;">

	<div class="content-padding-new home-rows-top">
		<a class="home-rows-header" style="text-decoration: none;" href="/">
			<h5 style="color: #8e9194;">404錯誤</h5>
			<h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">找不到該頁面</h3>
		</a>
	</div>

</div>

@include('layouts.footer')

@endsection
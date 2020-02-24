@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5;">
		@if (Auth::user()->id == $user->id)
			{{ $user->email }}
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
		        {{ csrf_field() }}
		        <button type="submit">登出</button>
		    </form>
		@endif
	</div>
</div>

@endsection
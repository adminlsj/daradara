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
		@include('video.home-default')
	</div>
</div>

@endsection
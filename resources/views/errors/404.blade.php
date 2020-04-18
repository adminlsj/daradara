@extends('layouts.app')

@section('nav')
<<<<<<< HEAD
	@include('layouts.nav-main-original', ['theme' => 'white'])
=======
	@include('nav.top')
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
<<<<<<< HEAD
    @include('video.sidebarMenu', ['theme' => 'white'])
=======
    @include('nav.side')
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5;">
		<div style="margin: 0 auto 0 auto; padding-top: 10px;">
		    <div style="text-align: center;" class="paravi-padding-setup">
		    	<h1>該頁面不存在<span class="hidden-xs"></h1>
		    </div>
		</div>
	</div>
</div>

@endsection
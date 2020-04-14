@extends('layouts.app')

@section('nav')
	@include('nav.top')
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('nav.side')
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5;">
	    
	</div>
</div>

@endsection
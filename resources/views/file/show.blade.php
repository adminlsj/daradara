@extends('layouts.app')

@section('nav')
	@include('nav.md')
@endsection

@section('content')

<div style="margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; height: 60vh; width: 500px; background-color: #232325; border-radius: 8px; padding: 20px;;">
	<div style="color: #a3a3a3; font-weight: 300;">{{ App\Helper::getSize($file->size) }}&nbsp;&nbsp;&nbsp;{{ Carbon\Carbon::parse($file->created_at)->format('Y-m-d') }}</div>
	<div style="color: #d6d6d6; font-size: 26px; font-weight: 400; margin-top: 5px;">{{ $file->title }}.{{ $file->extension }}</div>


	<div style="outline-style: dotted; margin-top: 15px; height: calc(100% - 137px); position: relative; background-color: #EDEDED; border-radius: 8px;">
		<img class="no-select" style="height: 100px; margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" src="https://pbs.twimg.com/media/GNTXhV2WUAA9e0C?format=png&name=240x240">
	</div>

	<div class="no-select" style="background-color: #BA9F33; line-height: 44px; height: 44px; border-radius: 8px; margin-top: 15px; font-size: 16px; color: white; cursor: pointer;">
		Download
	</div>
</div>

@include('layouts.footer')

@endsection
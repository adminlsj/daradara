@extends('layouts.app')

@section('nav')
	@include('nav.md')
@endsection

@section('content')

<div class="filebox-wrapper">
	<div style="color: #a3a3a3; font-weight: 300;">{{ App\Helper::getSize($file->size) }}&nbsp;&nbsp;&nbsp;{{ Carbon\Carbon::parse($file->created_at)->format('Y-m-d') }}</div>
	<div style="color: #d6d6d6; font-size: 26px; font-weight: 400; margin-top: 5px;">{{ $file->title }}.{{ $file->extension }}</div>


	<div class="filebox" style="height: calc(100% - 137px); background-color: #EDEDED;">
		<img class="no-select" style="height: 100px; margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" src="https://pbs.twimg.com/media/GNTXhV2WUAA9e0C?format=png&name=240x240">
	</div>

	<a href="{{ $download_url }}" target="_blank" style="text-decoration: none; cursor: pointer;">
		<div class="no-select" style="background-color: #BA9F33; line-height: 44px; height: 44px; border-radius: 8px; margin-top: 15px; font-size: 16px; color: white;">
			Download
		</div>
	</a>
</div>

@include('layouts.footer')

@endsection
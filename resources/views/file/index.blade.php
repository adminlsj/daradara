@extends('layouts.app')

@section('nav')
	@include('nav.md')
@endsection

@section('content')

<div id="loginModal" class="list-rows-wrapper" style="padding: 0 13.6%; color: white; margin-top: 70px !important;">
	<div style="text-align: center; border-radius: 8px; padding: 20px; color: white;">
		<table>
			<tr>
			    <th>id</th>
			    <th>user_id</th>
			    <th>title</th>
			    <th>extension</th>
			    <th>size</th>
			    <th>url</th>
			    <th>views</th>
			    <th>downloads</th>
			    <th>client_ip</th>
			    <th>created_at</th>
			    <th>updated_at</th>
			    <th>show</th>
			</tr>
			@foreach ($files as $file)
				<tr>
				    <th>{{ $file->id }}</th>
				    <th>{{ $file->user_id }}</th>
				    <th>{{ $file->title }}</th>
				    <th>{{ $file->extension }}</th>
				    <th>{{ $file->size }}</th>
				    <th>{{ $file->url }}</th>
				    <th>{{ $file->views }}</th>
				    <th>{{ $file->downloads }}</th>
				    <th>{{ $file->client_ip }}</th>
				    <th>{{ $file->created_at }}</th>
				    <th>{{ $file->updated_at }}</th>
				    <th><a href="{{ route('file.show', ['file' => $file]) }}/{{ $file->title }}.{{ $file->extension }}" target="_blank">Show</a></th>
				</tr>
			@endforeach
		</table>
	</div>
</div>

@include('layouts.footer')

@endsection
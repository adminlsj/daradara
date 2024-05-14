@extends('layouts.app')

@section('nav')
	@include('nav.md')
@endsection

@section('content')

<div class="filebox-wrapper">
	<div style="color: #a3a3a3; font-weight: 300;">Upload, Store, Download.</div>
	<div style="color: #d6d6d6; font-size: 26px; font-weight: 400; margin-top: 5px;">All in a Swift</div>

	@if (Auth::check() && Auth::user()->id == 1)
		<div class="filebox">
			<form id="fileStore" action="{{ route('file.store', ['user' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div style="position: relative; width: 200px; display: inline-block; margin-right: 110px;" class="form-group">
		            <input style="background-color: white; height: 45px;" readonly="readonly" type="text" class="form-control" name="file-text" id="file-text" placeholder="Share your file" required>
		            <label class="upload-image-btn" style="border-top-right-radius: 3px; border-bottom-right-radius: 3px;">
					    <input type="file" name="image" id="image" required>
					    <span style="color: #666666; font-weight: 500;">Browse</span>
					</label>
		        </div>

		        <button id="fileStore-submit-btn" style="display: block; height: 45px; font-size: 1em; width: 103px; background-color: red !important; border: none; text-align: center;" type="submit" class="btn btn-info">Upload</button>
			</form>
		</div>
	@else
		<div class="filebox">
			<img class="no-select" style="height: 100px; margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" src="https://pbs.twimg.com/media/GNS3plcWMAAyRva?format=png&name=240x240">
		</div>
	@endif
</div>

@include('layouts.footer')

@endsection
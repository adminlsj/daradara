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
		<div class="filebox" data-toggle="modal" data-target="#subscribeModal">
			<img class="no-select" style="height: 100px; margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" src="https://pbs.twimg.com/media/GNS3plcWMAAyRva?format=png&name=240x240">
		</div>
	@endif
</div>

@include('layouts.footer')

<form action="{{ route('subscribe.store') }}" method="GET">
	<div id="subscribeModal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">Upload currently disabled</h4>
	      </div>
	      <div class="modal-body" style="padding-bottom: 20px; text-align: left;">
	        <h4>Subscribe to updates</h4>
	        <p id="hentai-tags-text" style="color: darkgray; padding-bottom: 10px">Upload is currently disabled for new users, subscribe to get latest update about the upload status!</p>
	        <div class="addthis_inline_share_toolbox"></div>
	        <input style="width: 280px; color: black;" type="text" class="form-control-plaintext" name="user-email" id="user-email" value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="Email address">
	      </div>
	      <hr style="border-color: #323434; margin: 0; margin-top: 0px;">
	      <div class="modal-footer">
	        <div data-dismiss="modal">Back</div>
	        <button type="submit" name="submit" class="pull-right btn btn-primary">Subscribe</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>

@endsection
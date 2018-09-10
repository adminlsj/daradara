@extends('layouts.app')

@section('content')
<div class="container" style="width: 85%">
    <div class="row">
    	<div class="col-md-12">
    		<div style="margin-top: 40px;">
				<h3 style="color: grey; font-weight: 300">Application History in 6 months</h3>
				<hr>
			</div>
			<div style="font-weight:600" class="row application-list">
				<div class="col-md-5">
					Position
				</div>
				<div class="col-md-3">
					Company
				</div>
				<div class="col-md-2">
					Date Applied
				</div>
				<div class="col-md-1">
					Resume
				</div>
				<div class="col-md-1">
					Status
				</div>
			</div>
			@foreach ($apps as $app)
				<div class="row application-list">
					<div class="col-md-5">
						<a id="appListTitle{{ $app->id }}" style="" href="{{ route('job.show', ['job' => $app->job->id]) }}" target="_blank">{{ $app->job->title }}</a>
					</div>
					<div class="col-md-3">
						<form action="{{ route('job.search') }}" method="GET">
						<input name="title" value="{{ $app->job->company->name }}" type="hidden">
						<button style="text-align:left; width:100%; padding:0px; border:0px;" type="submit">{{ $app->job->company->name }}</button>
					</form>
					</div>
					<div class="col-md-2">
						{{ $app->created_at->toDateString() }}
					</div>
					<div class="col-md-1">
						<a href="{{ route('resume.edit', ['resume' => $resume]) }}" target="_blank">View</a>
					</div>
					<div class="col-md-1">
						{{ $app->status }}
					</div>
				</div>
			@endforeach
        </div>
        <!-- <div class="col-md-1" style="padding-left: 25px">
			<div style="margin-top: 40px;">
				<h3 style="color: grey; font-weight: 300">Jobs for you</h3>
				<hr>
			</div>
		</div> -->
    </div>
    <br><br><br><br><br><br>
</div>
      
@endsection
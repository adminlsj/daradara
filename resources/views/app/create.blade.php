@extends('layouts.app')

@section('content')
<div style="padding-top:40px; background-color:#E6E6E6;">
	<form action="{{ route('app.store') }}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="container card-shadow resume-form-container">
		    <div style="font-size: 25px">APPLICATION for <span style="font-weight: 600">{{ $job->title }}</span> at <span style="font-weight: 600">{{ $job->company->name }}</span></div>
		    <br>

		    @include('resume.form')
			<input name="job_id" value="{{ $job->id }}" type="hidden">
			<br>
			
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<button style="font-size: 15px;line-height: 30px;" type="submit" target="_blank" class="btn btn-info">Submit Application</button>
				</div>
			</div>
		</div>
	</form>
	<br><br><br>
</div>
@endsection
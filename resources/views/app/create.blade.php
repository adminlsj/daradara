@extends('layouts.app')

@section('content')
<div style="padding-top:40px; background-color:#E6E6E6;">
	<div class="container card-shadow resume-form-container">
		@include('layouts.error')
		<form action="{{ route('app.store') }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
		    <div style="font-size: 25px">將簡歷發送至 <span style="font-weight: 600">{{ $job->company->name }}</span> 應聘職位 <span style="font-weight: 600">{{ $job->title }}</span></div>
		    <br>

		    @include('resume.form')
			<input name="job_id" value="{{ $job->id }}" type="hidden">
			<br>
			
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4">
					<button style="font-size: 15px;line-height: 30px;" type="submit" target="_blank" class="btn btn-info">發送簡歷</button>
				</div>
			</div>
		</form>
	</div>
	<br><br><br>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div style="padding-top:40px; background-color:#edeeee;">
	<div class="container card-shadow resume-form-container">
		@include('layouts.error')
		<form action="{{ route('resume.update', ['resume' => $resume->id]) }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

		    <div style="font-size: 25px">RESUME &nbsp;<small>(Last Updated On: {{ $resume->updated_at->toDateString() }})</small></div>
		    <br>
		    @include('resume.form')
			<br>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<button style="font-size: 15px;line-height: 30px;" type="submit" class="btn btn-info">Save</button>
				</div>
			</div>
		</form>
	</div>
	<br><br><br>
</div>
@endsection
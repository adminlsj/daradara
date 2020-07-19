@extends('layouts.app')

@section('content')

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

<div class="paravi-padding-setup" style="padding-top: 20px">
	<div class="row" style="text-align: center">
		@foreach (App\Bot::$models as $modal)
			<a href="/database/{{ $modal }}" class="col-md-2" style="padding: 10px; margin-bottom: 10px">
				<div class="material-icons">dashboard</div>
				<div>{{ $modal }}</div>
			</a>
		@endforeach
	</div>
</div>

@include('layouts.nav-bottom')

@endsection
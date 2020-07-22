@extends('layouts.app')

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
  @include('layouts.sidebarMenu', ['theme' => 'white'])
</div>

<div style="height: 100%; padding: 20px 30px">
	<form action="{{ route('database.update', ['table' => $table, 'id' => $row->id]) }}" method="POST">
		{{ csrf_field() }}
		@foreach ($columns as $column)
			<div style="padding: 5px 0px; font-weight: bold">{{ $column }}:</div>
			<div style="margin-bottom: 10px">
				@switch($column)
				    @case($column == 'id' || $column == 'user_id' || $column == 'views' || $column == 'playlist_id')
				        <input type="number" class="form-control" name="{{ $column }}" id="{{ $column }}" placeholder="{{ $column }}" value="{{ $row->{$column} }}" required>
				        @break

				    @case($column == 'title' || $column == 'cover' || $column == 'tags' || $column == 'imgur' || $column == 'sd' || $column == 'name' || $column == 'email' || $column == 'password' || $column == 'provider' || $column == 'provider_id' || $column == 'remember_token' || $column == 'alert' || $column == 'temp')
				        <input type="text" class="form-control" name="{{ $column }}" id="{{ $column }}" placeholder="{{ $column }}" value="{{ $row->{$column} }}" {{ $column == 'foreign_sd' || $column == 'temp' ? '' : 'required' }}>
				        @break

				    @case($column == 'description' || $column == 'caption')
				        <textarea class="form-control" name="{{ $column }}" id="{{ $column }}" rows="5" required>{{ $row->{$column} }}</textarea>
				        @break

				    @case($column == 'outsource')
				        <div>
						  <input type="checkbox" {{ $row->{$column} ? 'checked' : ''}} id="{{ $column }}" name="{{ $column }}">
						  <label for="defaultCheck1" style="font-weight: normal">
						    {{ $column }}
						  </label>
						</div>
				        @break

				    @case($column == 'foreign_sd' || $column == 'data')
				        <input type="text" class="form-control" name="{{ $column }}" id="{{ $column }}" placeholder="{{ $column }}" value="{{ json_encode($row->{$column}, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) }}">
				        @break

				    @case($column == 'created_at' || $column == 'updated_at' || $column == 'uploaded_at')
				        <input type="datetime" class="form-control" name="{{ $column }}" id="{{ $column }}" value="{{ $row->{$column} }}" required="">
				        @break
				
				    @default
					    {{ $column }}
				@endswitch
			</div>
		@endforeach
		<button style="margin-top:10px; height: 45px; font-size: 1em; margin-bottom: 15px; width: 103px; background-color: red !important; border: none;" type="submit" class="btn btn-info">save</button>
	</form>
</div>

@include('layouts.nav-bottom')

@endsection
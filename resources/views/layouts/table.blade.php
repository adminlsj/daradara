@extends('layouts.app')

@section('content')

<div class="row no-gutter" style="text-align:center;">
	@foreach (App\Bot::$models as $modal)
		<a href="/database/{{ $modal }}" class="col-md-1" style="padding: 6px; border: solid 1px black; {{ strpos(URL::current(), $modal) !== false ? 'background-color: gray' : '' }}">
			<div>{{ $modal }}</div>
		</a>
	@endforeach
</div>

<div class="row no-gutter">
	<div class="col-md-1">
		<select class="form-control" id="column" style="border: solid 1px black; border-radius: 0px">
	    	@foreach ($columns as $column)
				<option {{ Request::get('column') == $column ? 'selected' : ''}}>{{ $column }}</option>
			@endforeach
	    </select>
	</div>
	<div class="col-md-1">
		<select class="form-control" id="expression" style="border: solid 1px black; border-radius: 0px">
			<option {{ Request::get('expression') == 'contains' ? 'selected' : ''}}>contains</option>
			<option {{ Request::get('expression') == 'is exactly' ? 'selected' : ''}}>is exactly</option>
	    </select>
	</div>
	<div class="col-md-9">
		<input type="text" class="form-control" name="dbquery" id="dbquery" style="border: solid 1px black; border-radius: 0px" value={{ Request::get('dbquery') }}>
	</div>
	<div class="col-md-1">
		<button id="database-search-btn" style="border: solid 1px black; border-radius: 0px; width: 100%; padding: 6px; text-decoration: none;">Search</button>
	</div>
</div>

<div style="font-size: 12px">

	<div style="overflow-x: scroll;">
		<table border = "1" cellpadding = "5" cellspacing = "5">
			<tr>
				@foreach ($columns as $column)
					<th style="padding: 5px 10px; {{ Request::get('sort') == $column && Request::get('order') == 'desc' ? 'background-color: gray' : '' }}">
						<a class="database-column" style="text-decoration: none; color: #333333; width: 100%; cursor: pointer;" data-sort={{ $column }}>
							{{ $column }}
						</a>
					</th>
				@endforeach
			</tr>
			@foreach ($results as $result)
				<tr>
					@foreach ($columns as $column)
						<td>
							<a href="/database/{{ $table }}/{{ $result->id }}/edit" target="_blank" style="text-decoration: none; color: #333333">
								@if ($column == 'foreign_sd' || $column == 'data')
									<div style="padding: 5px 10px; min-width: 100px; overflow-wrap: break-word;">{{ json_encode($result->{$column}, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) }}</div>
								@elseif ($column == 'title')
									<div style="padding: 5px 10px; min-width: 200px; overflow-wrap: break-word;">{{ $result->{$column} }}</div>
								@elseif ($column == 'caption')
									<div style="padding: 5px 10px; min-width: 400px; overflow-wrap: break-word;">{{ $result->{$column} }}</div>
								@elseif ($column == 'tags')
									<div style="padding: 5px 10px; min-width: 200px; overflow-wrap: break-word;">{{ $result->{$column} }}</div>
								@else
									<div style="padding: 5px 10px; max-width: 500px; overflow-wrap: break-word;">{{ $result->{$column} }}</div>
								@endif
							</a>
						</td>
					@endforeach
				</tr>
			@endforeach
		</table>
	</div>

	<div style="text-align: center;">{!! $results->appends($_GET)->links() !!}</div>
</div>

@include('layouts.nav-bottom')

@endsection
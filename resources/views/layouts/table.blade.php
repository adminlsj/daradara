@extends('layouts.app')

@section('content')

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

<div class="paravi-padding-setup" style="padding-top: 20px;">
	<div class="row" style="text-align: center; margin-bottom: 10px">
		@foreach (App\Bot::$models as $modal)
			<a href="/database/{{ $modal }}" class="col-md-2" style="padding: 10px; margin-bottom: 10px">
				<div class="material-icons">dashboard</div>
				<div>{{ $modal }}</div>
			</a>
		@endforeach
	</div>

	<div style="overflow-x: scroll;">
		<table border = "1" cellpadding = "5" cellspacing = "5">
			<tr>
				@foreach ($columns as $column)
					<th style="padding: 5px 10px; {{ Request::get('sort') == $column ? 'background-color: gray' : '' }}">
						<a href="/database/{{ $table }}?sort={{ $column }}&order=desc" style="text-decoration: none; color: #333333; width: 100%;">
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
									<div style="padding: 5px 10px; min-width: 300px; overflow-wrap: break-word;">{{ json_encode($result->{$column}, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) }}</div>
								@elseif ($column == 'title')
									<div style="padding: 5px 10px; min-width: 300px; overflow-wrap: break-word;">{{ $result->{$column} }}</div>
								@elseif ($column == 'caption' || $column == 'tags')
									<div style="padding: 5px 10px; min-width: 500px; overflow-wrap: break-word;">{{ $result->{$column} }}</div>
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
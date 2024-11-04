@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content') 

<div class="flex-column">
	<div class="character-headings flex-row">
		<div class="character-cover">
			<img src="{{ $staff->photo_cover }}" alt="{{ $staff->name_zht }}">
		</div>
		<div class="character-heading-content flex-column">
			<h3> {{ $staff->name_en }} </h3>
			<p> {{ $staff->nickname }} </p>
			<div class="character-info">
				<p> 生日：{{ $staff->birthday }} </p>
				<p> 年齡：{{ $staff->initial_age }} </p>
				<p> 性別：{{ $staff->gender }} </p>
				<p> 身高：{{ $staff->height }} </p>
			</div>
			<p> {{ $staff->description }} </p>
		</div>
	</div>

	<div class="character-animes flex-column">
		<div class="character-button-groups flex-row">
			<button>顯示收藏清單上</button>
			<button>日本</button>
			<button>人氣</button>
		</div>

		<div class="related-animes flex-row">
			@foreach ($animes as $anime)
				<div class="media-card">
					<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
						<img src="{{ $anime->photo_cover }}" alt="">
					</a>
					<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
						<div>{{ $anime->title_ro }}</div>
						<div style="font-size: 12px; color: dimgray;">{{ $anime->pivot->role }}</div>
					</a>
				</div>
			@endforeach
		</div>
	</div>
</div>
</div>

@endsection
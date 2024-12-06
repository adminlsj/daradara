@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content') 

<div class="flex-column">
	<div class="character-wrap">
		<div class="character-headings">
			<div class="character-cover">
				<img src="{{ $staff->photo_cover }}" alt="{{ $staff->name_zht }}">
			</div>
			<div class="character-heading-content flex-column">
				<div class="character-name-wrap">
					<h3> {{ $staff->name_jp }} </h3>
					<button class="favorite">♥ 693</button>
				</div>
				<p> {{ $staff->nickname }} </p>
				<div class="character-info">
					<p> 生日：{{ $staff->birthday }} </p>
					<p> 年齡：{{ $staff->initial_age }} </p>
					<p> 性別：{{ $staff->gender }} </p>
					<p> 身高：{{ $staff->height }} </p>
				</div>
				<p class="character-description"> {{ $staff->description }} </p>
			</div>
		</div>
		<div class="character-info-mobile">
			<p> 生日：{{ $staff->birthday }} </p>
			<p> 年齡：{{ $staff->initial_age }} </p>
			<p> 性別：{{ $staff->gender }} </p>
			<p> 身高：{{ $staff->height }} </p>
			<p> {{ $staff->description }} </p>
		</div>
	</div>

	<div class="character-anime-wrap">
		<div class="character-animes flex-column">
			<div class="character-button-groups flex-row">
				<button>顯示收藏清單上</button>
				<button>日本</button>
				<button>人氣</button>
			</div>

			<div class="related-animes">
				@foreach ($animes_actor as $anime)
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

				@foreach ($animes_staff as $anime)
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
</div>

@endsection
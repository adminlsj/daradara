@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content') 

<div class="flex-column">
	<div class="character-wrap">
		<div class="character-headings">
			<div class="character-cover">
				<img src="{{ $character->photo_cover }}" alt="{{ $character->name_zht }}">
			</div>
			<div class="character-heading-content flex-column">
				<div class="character-name-wrap">
					<h3> {{ $character->name_jp }} </h3>
					<button class="favorite">♥ 693</button>
				</div>
				<p> {{ $character->nickname }} </p>
				<div class="character-info">
					<p> 生日：{{ $character->birthday }} </p>
					<p> 年齡：{{ $character->initial_age }} </p>
					<p> 性別：{{ $character->gender }} </p>
					<p> 身高：{{ $character->height }} </p>
				</div>
				<p class="character-description"> {{ $character->description }} </p>
			</div>
		</div>
		<div class="character-info-mobile">
			<p> 生日：{{ $character->birthday }} </p>
			<p> 年齡：{{ $character->initial_age }} </p>
			<p> 性別：{{ $character->gender }} </p>
			<p> 身高：{{ $character->height }} </p>
			<p> {{ $character->description }} </p>
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
				@foreach ($animes as $anime)
					<div class="media-card">
						<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
							<img src="{{ $anime->photo_cover }}" alt="">
						</a>
						<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">{{ $anime->title_ro }}</a>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
</div>

@endsection
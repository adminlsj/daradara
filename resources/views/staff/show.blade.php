@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content') 

{{ Session::put('redirectTo', Request::url()) }}

<div class="flex-column" style="margin-top: 68px;">
	<div class="character-wrap" style="padding-bottom: 50px;">
		<div class="character-headings">
			<div class="character-cover">
				<img src="{{ $staff->photo_cover }}" alt="{{ $staff->name_zht }}">
			</div>
			<div class="character-heading-content flex-column">
				<div class="character-name-wrap">
					<div class="character-name">
						{{ $staff->getTitle($chinese) }}
						<form style="margin-top: -5px;" class="like-form pull-right" action="{{ route('like.create', ['type' => 'App\Staff', 'id' => $staff->id]) }}" method="POST">
	                        {{ csrf_field() }}
	                        <button class="no-button-style" type="submit">
	                            <span style="color: {{ Auth::check() ? App\Like::where('user_id', Auth::user()->id)->where('likeable_id', $staff->id)->where('likeable_type', 'App\Staff')->first() ? '#810000' : 'white' : 'white'}}">♥</span>&nbsp;&nbsp;&nbsp;{{ App\Like::where('likeable_id', $staff->id)->where('likeable_type', 'App\Staff')->count() }}
	                        </button>
	                    </form>
					</div>
					<div class="character-name-alt">{{ $staff->name_zhs && $staff->name_zhs != $staff->getTitle($chinese) ? $staff->name_zhs.', ' : '' }}{{ $staff->name_jp && $staff->name_jp != $staff->getTitle($chinese) ? $staff->name_jp.', ' : '' }}{{ $staff->name_en ? str_replace(', ', ' ', $staff->name_en) : '' }}</div>
				</div>
				<p> {{ $staff->nickname }} </p>
				<div class="character-info" style="margin-top: 10px;">
					<div><b>生日：</b>{{ $staff->birthday ? $staff->birthday->toDateString() : '' }} </div>
					<div><b>年齡：</b>{{ $staff->birthday ? $staff->birthday->age : '' }} </div>
					<div><b>性別：</b>{{ $staff->gender }} </div>
					<div><b>身高：</b>{{ $staff->height }} </div>
				</div>
				<p class="character-description" style="margin-top: 10px;"> {{ $staff->description }} </p>
			</div>
		</div>
	</div>

	<div class="character-anime-wrap" style="padding-top: 40px">
		<div class="character-animes flex-column">
			<!-- <div class="character-button-groups flex-row">
				<button>顯示收藏清單上</button>
				<button>日本</button>
				<button>人氣</button>
			</div> -->

			@for ($i = 2025; $i > 2000; $i--)
				@php
					$related_animes = $animes_actor->where('started_at', '!=', null)->filter(function ($value) use ($i) {
                        return $value->started_at->year === $i;
                    })
	            @endphp
	            @if ($related_animes != '[]')
	            	<div class="related-animes-year">{{ $i }}</div>
					<div class="related-animes">
						@foreach ($related_animes as $anime)
							@foreach ($anime->characters as $character)
								<div class="staff-media-card" style="width: 185px; position: relative;">
									<a class="cover" href="{{ route('character.show', ['character' => $character, 'title' => $character->getName($chinese)]) }}">
										<img src="{{ $character->photo_cover }}" alt="">
									</a>
									<a class="relation-image" style="position: absolute;" href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->getTitle($chinese)]) }}">
										<img src="{{ $anime->photo_cover }}" alt="">
									</a>
									<a href="{{ route('character.show', ['character' => $character, 'title' => $character->getName($chinese)]) }}">
										<div class="name">{{ $character->getName($chinese) }}</div>
									</a>
									<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->getTitle($chinese)]) }}">
										<div class="name-alt" style="font-size: 12px; color: dimgray;">{{ $anime->getTitle($chinese) }}</div>
									</a>
								</div>
							@endforeach
						@endforeach
					</div>
					<br><br>
	            @endif
			@endfor

			<div class="related-animes">
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
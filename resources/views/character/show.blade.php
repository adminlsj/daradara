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
				<img src="{{ $character->photo_cover }}" alt="{{ $character->getName($chinese) }}">
			</div>
			<div class="character-heading-content flex-column">
				<div class="character-name-wrap">
					<div class="character-name">
						{{ $character->getName($chinese) }}
						<form style="margin-top: -5px;" class="like-form pull-right" action="{{ route('like.create', ['type' => 'App\Character', 'id' => $character->id]) }}" method="POST">
	                        {{ csrf_field() }}
	                        <button class="no-button-style" type="submit">
	                            <span style="color: {{ Auth::check() ? App\Like::where('user_id', Auth::user()->id)->where('likeable_id', $character->id)->where('likeable_type', 'App\Character')->first() ? '#810000' : 'white' : 'white'}}">♥</span>&nbsp;&nbsp;&nbsp;{{ App\Like::where('likeable_id', $character->id)->where('likeable_type', 'App\Character')->count() }}
	                        </button>
	                    </form>
					</div>
					<div class="character-name-alt">{{ $character->name_zhs && $character->name_zhs != $character->getName($chinese) ? $character->name_zhs.', ' : '' }}{{ $character->name_jp && $character->name_jp != $character->getName($chinese) ? $character->name_jp.', ' : '' }}{{ $character->name_en ? str_replace(', ', ' ', $character->name_en) : '' }}</div>
				</div>
				<p> {{ $character->nickname }} </p>
				<div class="character-info" style="margin-top: 10px;">
					<div><b>生日：</b>{{ $character->birthday ? $character->birthday->toDateString() : '' }} </div>
					<div><b>年齡：</b>{{ $character->birthday ? $character->birthday->age : '' }} </div>
					<div><b>性別：</b>{{ $character->gender }} </div>
					<div><b>身高：</b>{{ $character->height }} </div>
				</div>
				<p class="character-description" style="margin-top: 10px;"> {{ $character->description }} </p>
			</div>
		</div>
	</div>

	<div class="character-anime-wrap" style="padding-top: 40px; padding-bottom: 40px;">
		<div class="character-animes flex-column">
            @if ($animes)
				<div class="related-animes">
					@foreach ($animes as $anime)
						@foreach ($anime->staffs as $staff)
							<div class="staff-media-card">
								<a class="cover" href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->getTitle($chinese)]) }}">
									<img src="{{ $anime->photo_cover }}" alt="">
								</a>
								<a class="relation-image" href="{{ route('staff.show', ['staff' => $staff->id, 'title' => $staff->getName($chinese)]) }}">
									<img src="{{ $staff->photo_cover }}" alt="">
								</a>
								<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->getTitle($chinese)]) }}">
									<div class="name">{{ $anime->getTitle($chinese) }}</div>
								</a>
								<a href="{{ route('staff.show', ['staff' => $staff->id, 'title' => $staff->getName($chinese)]) }}">
									<div class="name-alt">{{ $staff->getName($chinese) }}</div>
								</a>
							</div>
						@endforeach
					@endforeach
				</div>
				<br>
            @endif
		</div>
	</div>
</div>

@endsection
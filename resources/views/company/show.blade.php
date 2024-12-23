@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')

<div class="flex-column" style="margin-top: 68px;">
    <div class="character-wrap" style="padding-bottom: 50px;">
        <div class="character-headings">
            <div class="character-cover">
                <img src="{{ $company->photo_cover }}" alt="{{ $company->getName($chinese) }}">
            </div>
            <div class="character-heading-content flex-column">
                <div class="character-name-wrap">
                    <div class="character-name">
                        {{ $company->getName($chinese) }}
                        <form style="margin-top: -5px;" class="like-form pull-right" action="{{ route('like.create', ['type' => 'App\Company', 'id' => $company->id]) }}" method="POST">
                            {{ csrf_field() }}
                            <input id="redirectTo" name="redirectTo" type="hidden" value="{{ Request::url() }}">
                            <button class="no-button-style" type="submit">
                                <span style="color: {{ Auth::check() ? App\Like::where('user_id', Auth::user()->id)->where('likeable_id', $company->id)->where('likeable_type', 'App\Company')->first() ? '#810000' : 'white' : 'white'}}">♥</span>&nbsp;&nbsp;&nbsp;{{ App\Like::where('likeable_id', $company->id)->where('likeable_type', 'App\Company')->count() }}
                            </button>
                        </form>
                    </div>
                    <div class="character-name-alt">{{ $company->name_zhs && $company->name_zhs != $company->getName($chinese) ? $company->name_zhs.', ' : '' }}{{ $company->name_jp && $company->name_jp != $company->getName($chinese) ? $company->name_jp.', ' : '' }}{{ $company->name_en ? str_replace(', ', ' ', $company->name_en) : '' }}</div>
                </div>
                <div class="character-info" style="margin-top: 10px;">
                    <div><b>創立日期：</b>{{ $company->started_at ? $company->started_at->toDateString() : '' }} </div>
                    <div><b>閉業日期：</b>{{ $company->ended_at ? $company->ended_at->toDateString() : '' }} </div>
                    <div><b>地址：</b>{{ $company->location }} </div>
                    <div><b>網站：</b>{{ $company->website }} </div>
                </div>
                <p class="character-description" style="margin-top: 10px;"> {{ $company->description }} </p>
            </div>
        </div>
    </div>

    <div class="character-anime-wrap" style="padding-top: 40px;">
        <div class="character-animes flex-column">
            @for ($i = 2025; $i > 2000; $i--)
                @php
                    $related_animes = $animes->where('started_at', '!=', null)->filter(function ($value) use ($i) {
                        return $value->started_at->year === $i;
                    })
                @endphp
                @if ($related_animes != '[]')
                    <div class="related-animes-year">{{ $i }}</div>
                    <div class="related-animes">
                        @foreach ($related_animes as $anime)
                            <div class="staff-media-card">
                                <a class="cover" href="{{ route('anime.show', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}">
                                    <img src="{{ $anime->photo_cover }}" alt="">
                                </a>
                                <a href="{{ route('anime.show', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}">
                                    <div class="name">{{ $anime->getTitle($chinese) }}</div>
                                </a>
                                <a href="{{ route('anime.show', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}">
                                    <div class="name-alt">{{ $anime->pivot->role }}</div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <br><br>
                @endif
            @endfor
        </div>
    </div>
</div>

@endsection
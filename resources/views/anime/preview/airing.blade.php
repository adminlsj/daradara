@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="flex-center-wrapper home-wrapper">
    <div class="flex-center-content flex-column">
        @include('anime.preview.button-groups')
        <div class="content-wrap preview-airing">
            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $dayOfWeek)
                <div class="landing-section preview-airing">
                    <div class="title-link">
                        <h3>{{ $dayOfWeek }}</h3>
                    </div>
                    <div class="media-wrap">
                        @foreach ($animes as $anime)
                            @if($carbon->parse($anime->started_at)->englishDayOfWeek == $dayOfWeek)
                                <div class="media-preview-card">
                                    <a href="{{ route('anime.show', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}">
                                        <img src="{{ $anime->photo_cover }}" alt=""></a>
                                    <div class="relations-content">
                                        <a href="{{ route('anime.show', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}">
                                            <div>
                                                <p>
                                                    {{ $anime->getTitle($chinese) }}
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
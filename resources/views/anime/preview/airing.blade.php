@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="flex-center-wrapper home-wrapper">
    <div class="flex-center-content flex-column" style="margin-top: 100px;">
        @include('anime.preview.button-groups')
        <div class="content-wrap preview-airing">
            <div class="landing-section">
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $dayOfWeek)
                    <div class="title-link">
                        <h3>{{ $dayOfWeek }}</h3>
                    </div>
                    <div class="media-wrap">
                        @foreach ($animes as $anime)
                            @if($carbon->parse($anime->started_at)->englishDayOfWeek == $dayOfWeek)
                                @include('anime.preview.media-card')
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="flex-center-wrapper home-wrapper">
    <div class="flex-center-content flex-column" style="margin-top: 100px;">
        @include('anime.preview.button-groups')
        <div class="preview-menu">
            @foreach(range(2024, 2000) as $year)
                <div class="preview-menu-card">
                    <h3>{{ $year }}</h3>
                    <div class="seasons">
                        @foreach(['Winter', 'Spring', 'Summer', 'Fall'] as $season)                       
                            <div class="season">
                                <a href="{{ route('preview.show', ['season' => $season, 'year' => $year]) }}" class="season">
                                    <img src="{{ $animes->where('season', $season . ' ' . $year)->first()->photo_cover }}"
                                        alt="">
                                    <div class="season-info">
                                        <div class="season-name">{{ $season }}</div>
                                        <div class="total">{{ $animes->where('season', $season . ' ' . $year)->count() }} Anime
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
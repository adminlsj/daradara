@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<form id="hentai-form" action="{{ route('preview.search', ['season' => $season, 'year' => $year]) }}" method="GET">
    <div class="preview-show flex-center-wrapper home-wrapper">
        <div class="flex-center-content flex-column">
            @include('anime.preview.button-groups')
            @include('anime.preview.search')

            <div class="content-wrap">
                <div class="landing-section">
                    <div class="title-link preview-mobile-title-link" id="TV">
                        <h3>TV</h3>
                        <div class="filter format sorting-mobile" style="position: relative;">
                            <div onclick="extra_filter_toggle()" class="extra-filter-wrap no-select"
                                style="background-color: transparent;" type="button" data-toggle="dropdown">
                                <div id="home-filter-more-btn">
                                    <i class="fa fa-sort"></i>
                                </div>
                            </div>
                            <div id="sorting-dropdown-mobile" class="dropdown-menu home-option-wrapper">
                                <input type="hidden" id="sorting-mobile" name="sorting-mobile" value="{{ $sorting }}">
                                @foreach (['標題', '人氣', '評分', '首播日期', '完播日期', '製作公司'] as $sorting)
                                    <div class="home-option sorting-option" data-input="sorting">{{ $sorting }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="media-wrap">
                        @foreach ($TV as $anime)
                            @include('anime.preview.media-card')
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="content-wrap">
                <div class="landing-section">
                    <div class="title-link" id="Movie">
                        <h3>Movie</h3>
                    </div>
                    <div class="media-wrap">
                        @foreach ($Movie as $anime)
                            @include('anime.preview.media-card')
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="content-wrap">
                <div class="landing-section">
                    <div class="title-link" id="OVA">
                        <h3>OVA / ONA / Special</h3>
                    </div>
                    <div class="media-wrap">
                        @foreach ($OVA as $anime)
                            @include('anime.preview.media-card')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
@endsection
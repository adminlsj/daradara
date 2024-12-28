@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<form id="preview-search-form" action="{{ route('preview.search', ['season' => 'Spring', 'year' => '2023']) }}"
    method="GET">
    <div class="flex-center-wrapper home-wrapper">
        <div class="flex-center-content flex-column" style="margin-top: 100px;">
            <div class="filter format flex-row" style="position: relative; justify-content:flex-end; gap:15px;">
                <div onclick="extra_filter_toggle()" class="extra-filter-wrap no-select"
                    style="background-color: transparent;" type="button" data-toggle="dropdown">
                    <div class="flex-column" id="home-filter-more-btn">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>
                <div onclick="extra_filter_toggle()" class="extra-filter-wrap no-select"
                    style="background-color: transparent;" type="button" data-toggle="dropdown">
                    <div id="home-filter-more-btn">
                        <i class="fa fa-bars"></i>
                    </div>
                </div>
            </div>
            @include('anime.preview.search')

            <div class="content-wrap">
                <div class="landing-section">
                    <div class="title-link">
                        <a href="">
                            <h3>TV</h3>
                        </a>
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
                    <div class="title-link">
                        <a href="">
                            <h3>Movie</h3>
                        </a>
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
                    <div class="title-link">
                        <a href="">
                            <h3>OVA / ONA / Special</h3>
                        </a>
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
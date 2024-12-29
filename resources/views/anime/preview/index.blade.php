@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<form id="preview-search-form" action="{{ route('preview.search', ['season' => 'Spring', 'year' => '2023']) }}"
    method="GET">
    <div class="flex-center-wrapper home-wrapper">
        <div class="flex-center-content flex-column" style="margin-top: 100px;">
            @include('anime.preview.button-groups')
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
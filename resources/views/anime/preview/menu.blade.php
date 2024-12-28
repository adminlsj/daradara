@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="flex-center-wrapper home-wrapper">
    <div class="flex-center-content flex-column" style="margin-top: 100px;">
        <div class="filter format flex-row" style="position: relative; justify-content:flex-end; gap:15px;">
            <div onclick="extra_filter_toggle()" class="extra-filter-wrap no-select"
                style="background-color: transparent;" type="button" data-toggle="dropdown">
                <div class="flex-column" id="home-filter-more-btn">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
            <a href="{{ route('preview.menu') }}">
                <div class="extra-filter-wrap no-select" style="background-color: transparent;">
                    <div id="home-filter-more-btn">
                        <i class="fa fa-bars"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="preview-menu">
            <div class="preview-menu-card">
                <h3>2024</h3>
                <div class="seasons">
                    <div class="season">
                        <a href="{{ route('preview.index', ['season' => 'Winter', 'year' => '2024']) }}" class="season">
                            <img src="{{ $Winter2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Winter</div>
                                <div class="total">{{ $Winter2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                    <div class="season">
                        <a href="{{ route('preview.index', ['season' => 'Spring', 'year' => '2024']) }}" class="season">
                            <img src="{{ $Spring2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Spring</div>
                                <div class="total">{{ $Spring2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                    <div class="season">
                        <a href="{{ route('preview.index', ['season' => 'Summer', 'year' => '2024']) }}" class="season">
                            <img src="{{ $Summer2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Summer</div>
                                <div class="total">{{ $Summer2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                    <div class="season">
                        <a href="{{ route('preview.index', ['season' => 'Fall', 'year' => '2024']) }}" class="season">
                            <img src="{{ $Fall2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Fall</div>
                                <div class="total">{{ $Fall2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="preview-menu-card">
                <h3>2023</h3>
                <div class="seasons">
                    <div class="season">
                        <a href="" class="season">
                            <img src="{{ $Winter2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Winter</div>
                                <div class="total">{{ $Winter2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                    <div class="season">
                        <a href="" class="season">
                            <img src="{{ $Spring2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Spring</div>
                                <div class="total">{{ $Spring2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                    <div class="season">
                        <a href="" class="season">
                            <img src="{{ $Summer2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Summer</div>
                                <div class="total">{{ $Summer2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                    <div class="season">
                        <a href="" class="season">
                            <img src="{{ $Fall2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Fall</div>
                                <div class="total">{{ $Fall2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="preview-menu-card">
                <h3>2022</h3>
                <div class="seasons">
                    <div class="season">
                        <a href="" class="season">
                            <img src="{{ $Winter2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Winter</div>
                                <div class="total">{{ $Winter2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                    <div class="season">
                        <a href="" class="season">
                            <img src="{{ $Spring2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Spring</div>
                                <div class="total">{{ $Spring2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                    <div class="season">
                        <a href="" class="season">
                            <img src="{{ $Summer2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Summer</div>
                                <div class="total">{{ $Summer2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                    <div class="season">
                        <a href="" class="season">
                            <img src="{{ $Fall2024->first()->photo_cover }}" alt="">
                            <div class="season-info">
                                <div class="season-name">Fall</div>
                                <div class="total">{{ $Fall2024->count() }} Anime</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
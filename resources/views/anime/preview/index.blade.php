@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<form id="preview-search-form" action="{{ route('preview.search', ['season' => 'spring', 'year' => '2023']) }}"
    method="GET">
    <div class="flex-center-wrapper home-wrapper">
        <div class="flex-center-content flex-column" style="margin-top: 100px;">
            @include('anime.preview.search')

            @foreach (['TV', 'Movie', 'OVA / ONA / Special'] as $category)
                <div class="content-wrap">
                    <div class="landing-section">
                        <div class="title-link">
                            <a href="">
                                <h3>{{ $category }}</h3>
                            </a>
                        </div>
                        <div class="media-wrap">

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
</form>
@endsection
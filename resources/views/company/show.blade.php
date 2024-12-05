@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content') 
<div class="company-content">
    <div class="company-wrapper">
        <div class="company-headings">
            <h3>{{ $company->name_en }}</h3>
            <button class="favorite">♥ 693</button>
        </div>
    </div>
    <div class="company-wrapper">
        <div class="company-animes flex-column">
            <div class="company-button-groups flex-row">
                <button>顯示收藏清單上</button>
                <button>日本</button>
                <button>人氣</button>
            </div>

            <div class="related-animes">
                @foreach ($animes as $anime)
                    <div class="media-card">
                        <a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
                            <img src="{{ $anime->photo_cover }}" alt="">
                        </a>
                        <a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">{{ $anime->title_ro }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>

@endsection
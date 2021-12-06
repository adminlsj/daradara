@extends('layouts.app')

@section('head')
    @parent
    @include('comic.cover-head')
@endsection

@section('nav')
  @include('nav.comic')
@endsection

@section('content')

@include('ads.comics-banner-exoclick')

<div class="comics-panel-margin comics-panel-padding">
  <div class="row">
    <div class="col-md-4">
      <a href="{{ route('comic.showContent', ['comic' => $comic, 'page' => 1]) }}">
        <img class="lazy" style="border-radius: 5px; width: 100%;" src="https://t.nhentai.net/galleries/{{ $comic->galleries_id }}/cover.{{ $comic->extension }}" data-src="https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/1.{{ App\Nhentai::$parseExt[$comic->extensions[0]] }}" data-srcset="https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/1.{{ App\Nhentai::$parseExt[$comic->extensions[0]] }}">
      </a>
    </div>
    <div class="col-md-8">
      <h3 class="title comics-metadata-top-row" style="line-height: 30px;">
        <span class="before" style="color: #999">{{ $comic->title_n_before }}</span>
        <span class="pretty" style="color: white">{{ $comic->title_n_pretty }}</span>
        <span class="after" style="color: #999">{{ $comic->title_n_after }}</span>
      </h3>

      <h4 class="title comics-metadata-margin-top" style="line-height: 30px;">
        <span class="before" style="color: #999">{{ $comic->title_o_before }}</span>
        <span class="pretty" style="color: white">{{ $comic->title_o_pretty }}</span>
        <span class="after" style="color: #999">{{ $comic->title_o_after }}</span>
      </h4>

      <h5 class="comics-metadata-margin-top" style="color: #999">#<span style="color: #d9d9d9">{{ $comic->id }}</span></h5>

      <div class="comics-metadata-margin-top">
        @foreach ($metadata as $key => $value)
          @if ($value)
            <h5 style="margin:0; color: #d9d9d9;">{{ App\Nhentai::$columns[$key] }}：
              @foreach ($value as $data)
                <a class="hover-lighter" href="{{ route('comic.searchTags', ['column' => $key, 'value' => $data]) }}"><div class="no-select" style="background-color: #4d4d4d; padding: 4px 7px; border-radius: 5px; color: #d9d9d9; cursor: pointer; display: inline-block; margin-bottom: 4px">{{ $data }}</div></a>
              @endforeach
            </h5>
          @endif
        @endforeach

        <h5 style="margin:0; color: #d9d9d9;">頁數：
          <div class="no-select" style="background-color: #4d4d4d; padding: 4px 7px; border-radius: 5px; color: #d9d9d9; cursor: pointer; display: inline-block; margin-bottom: 4px">{{ $comic->pages }}</div>
        </h5>

        <h5 style="margin:0; color: #d9d9d9;">上傳：
          <div class="no-select" style="background-color: #4d4d4d; padding: 4px 7px; border-radius: 5px; color: #d9d9d9; cursor: pointer; display: inline-block; margin-bottom: 4px">{{ Carbon\Carbon::parse($comic->created_at)->diffForHumans() }}</div>
        </h5>
      </div>

      <div class="comics-metadata-margin-top" style="opacity: 0.5; filter: alpha(opacity=50);">
        <button class="no-select" style="background-color: crimson; border: none; color: #d9d9d9; border-radius: 5px; padding: 10px 20px 10px 18px;">
          <span style="vertical-align: middle; font-size: 18px; margin-top: -3px; margin-right: 5px; cursor: pointer;" class="material-icons">favorite</span>加入最愛
        </button>
        <button class="no-select" style="background-color: #4d4d4d; border: none; color: #d9d9d9; border-radius: 5px; padding: 10px 20px 10px 15px;">
          <span style="vertical-align: middle; font-size: 20px; margin-top: -3px; margin-bottom: -2px; margin-right: 5px; cursor: pointer;" class="material-icons">download</span>下載
        </button>
      </div>

    </div>
  </div>
</div>

<div class="comics-panel-margin comics-panel-margin-top comics-panel-padding comics-thumbnail-wrapper comic-rows-wrapper" style="position: relative;">
  @for ($i = 1; $i <= $comic->pages; $i++)
    <a href="{{ route('comic.showContent', ['comic' => $comic, 'page' => $i]) }}">
      <img class="lazy comic-rows-videos-div hover-lighter {{ $i > 12 ? 'hidden' : '' }}" style="border-radius: 5px; margin-bottom: 4px; vertical-align: top" src="https://i.imgur.com/0n3iJ9Ol.jpg" data-srcset="https://t.nhentai.net/galleries/{{ $comic->galleries_id }}/{{ $i }}t.{{ App\Nhentai::$parseExt[$comic->extensions[$i - 1]] }}">
    </a>
  @endfor
  <div id="comics-thumbnail-show-btn-wrapper" style="{{ $comic->pages <= 12 ? 'display:none' : '' }}">
    <button id="show-more-comics-btn" class="no-select" style="background-color: crimson; border: none; color: #d9d9d9; border-radius: 5px; padding: 10px 20px 10px 18px;">
      <span style="vertical-align: middle; font-size: 18px; margin-top: -3px; margin-right: 5px; cursor: pointer;" class="material-icons">visibility</span>顯示更多
    </button>
    <button id="show-all-comics-btn" class="no-select" style="background-color: #4d4d4d; border: none; color: #d9d9d9; border-radius: 5px; padding: 10px 20px 10px 15px;">
      <span style="vertical-align: middle; font-size: 20px; margin-top: -3px; margin-bottom: -2px; margin-right: 5px; cursor: pointer;" class="material-icons">visibility</span>顯示全部
    </button>
  </div>
</div>

@if ($comics && $comics->count() > 1)
  <div class="comics-panel-margin comics-panel-margin-top comics-panel-padding-less comics-related-wrapper comic-rows-wrapper">
    <h3 style="text-align: center; color: #d9d9d9;">相關集數列表</h3>
    @foreach ($comics as $comic)
      @include('comic.card')
    @endforeach
  </div>
@endif

<div class="comics-panel-margin comics-panel-margin-top comics-panel-padding-less comics-related-wrapper comic-rows-wrapper">
    <h3 style="text-align: center; color: #d9d9d9;">更多相關漫畫</h3>
    @foreach ($related as $comic)
      @include('comic.card')
    @endforeach
</div>

@include('ads.comics-banner-juicyads')

@endsection
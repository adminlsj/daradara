@extends('layouts.app')

@section('nav')
  <span class="comics-nav">
    @include('nav.main-static')
  </span>
@endsection

@section('content')

@include('ads.comics-banner-exoclick')

<div id="comics-search-tag-top-row" style="text-align: center;">
  <h2 style="color: #d9d9d9;">
    {{ ucfirst($column) }}
    <div class="no-select" style="background-color: #4d4d4d; padding: 5px 10px; border-radius: 5px; color: #d9d9d9; cursor: pointer; display: inline-block; margin-bottom: 4px; display: inline-block; margin-left: 5px">{{ $value }}</div>
  </h2>

  <h4 class="comics-search-tag-tabs" style="color: #d9d9d9; font-weight: 400;">
    <a href="{{ route('comic.searchTags', ['column' => $column, 'value' => $value]) }}"><div class="no-select {{ !Request::is('*/popular*') ? 'active' : '' }}" style="margin-right: 15px; border-radius: 5px;">最新</div></a>
    <div class="no-select" style="border-top-left-radius: 5px; border-bottom-left-radius: 5px;">熱門 :</div>
    <a href="{{ route('comic.searchTags', ['column' => $column, 'value' => $value, 'time' => 'popular-today']) }}"><div class="no-select {{ Request::is('*/popular-today') ? 'active' : '' }}">本日</div></a>
    <a href="{{ route('comic.searchTags', ['column' => $column, 'value' => $value, 'time' => 'popular-week']) }}"><div class="no-select {{ Request::is('*/popular-week') ? 'active' : '' }}">本週</div></a>
    <a href="{{ route('comic.searchTags', ['column' => $column, 'value' => $value, 'time' => 'popular']) }}"><div class="no-select {{ Request::is('*/popular') ? 'active' : '' }}" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">所有</div></a>
  </h4>
</div>

<div class="comics-panel-margin comics-panel-margin-top comics-panel-padding-less comics-related-wrapper comic-rows-wrapper">
    @foreach ($comics as $comic)
      @include('comic.card')
    @endforeach
</div>

<div style="margin-top: 6px; margin-bottom: -27px" class="search-pagination hidden-xs">{!! $comics->appends(request()->query())->links() !!}</div>
<div style="margin-top: -10px; margin-bottom: -30px" class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $comics->appends(request()->query())->onEachSide(1)->links() !!}</div>

@include('ads.comics-banner-juicyads')

<script>
  var urlParams = new URLSearchParams(window.location.search);
  // $(".mobile-search-pagination .pagination .disabled").addClass('hidden-xs');
  if (urlParams.has('page') && urlParams.get('page') > 2) {
    $(".mobile-search-pagination .pagination .page-item:nth-child(3)").addClass('hidden');
  }
  if (urlParams.has('page') && urlParams.get('page') < {{ $comics->lastPage() }} - 1) {
    $(".mobile-search-pagination .pagination .page-item:nth-last-child(3)").addClass('hidden');
  }
</script>

@endsection
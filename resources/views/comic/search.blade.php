@extends('layouts.app')

@section('nav')
  @include('nav.comic')
@endsection

@section('content')

@include('ads.comics-banner-exoclick')

<div id="comics-search-tag-top-row" style="text-align: center;">
  <h2 style="color: #d9d9d9;">
    <span style="font-size: 33px; font-weight: bolder; vertical-align: middle; color: crimson; margin-top: -5px; margin-right: 5px" class="material-icons">search</span>{{ number_format($comics->total()) }} <span style="font-size: 25px;">個搜索結果</span>
  </h2>

  <h4 class="comics-search-tag-tabs" style="color: #d9d9d9; font-weight: 400;">
    <a href="{{ route('comic.search') }}?query={{ Request::get('query') }}"><div class="no-select {{ Request::get('sort') == '' ? 'active' : '' }}" style="margin-right: 15px; border-radius: 5px;">最新</div></a>
    <div class="no-select" style="border-top-left-radius: 5px; border-bottom-left-radius: 5px; cursor: auto;">熱門 :</div>
    <a href="{{ route('comic.search') }}?sort=popular-today&query={{ Request::get('query') }}"><div class="no-select {{ Request::get('sort') == 'popular-today' ? 'active' : '' }}">本日</div></a>
    <a href="{{ route('comic.search') }}?sort=popular-week&query={{ Request::get('query') }}"><div class="no-select {{ Request::get('sort') == 'popular-week' ? 'active' : '' }}">本週</div></a>
    <a href="{{ route('comic.search') }}?sort=popular&query={{ Request::get('query') }}"><div class="no-select {{ Request::get('sort') == 'popular' ? 'active' : '' }}" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">所有</div></a>
  </h4>
</div>

<div class="comics-panel-margin comics-panel-margin-top comics-panel-padding-less comics-related-wrapper comic-rows-wrapper">
    @foreach ($comics as $comic)
      @include('comic.card')
    @endforeach
</div>

<div style="margin-top: 6px; margin-bottom: -27px" class="search-pagination hidden-xs">{!! $comics->appends(request()->query())->links() !!}</div>
<div style="margin-top: -10px; margin-bottom: -30px" class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $comics->appends(request()->query())->onEachSide(1)->links() !!}</div>

<div class="{{ $comics->total() <= 30 ? 'comics-no-pagination-padding' : '' }}">
  @include('ads.comics-banner-juicyads')
</div>

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
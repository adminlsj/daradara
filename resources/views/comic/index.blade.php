@extends('layouts.app')

@section('nav')
  @include('nav.comic')
@endsection

@section('content')

<div style="overflow-y: hidden;">
  @include('ads.comics-banner-exoclick')

  @if (!isset($_GET['page']) || $_GET['page'] == 1)
    <div style="background-color: #222222; margin: 0 4%; padding: 5px 30px 25px 30px;">
        <h3 style="text-align: center; color: #d9d9d9; font-size: 20px; margin-bottom: 25px;"><span style="vertical-align: middle; margin-top: -5px; margin-right: 5px; color: crimson;" class="material-icons">local_fire_department</span>發燒漫畫</h3>
        @foreach ($trending as $comic)
          @include('comic.card')
        @endforeach
    </div>
  @endif

  <div class="comics-panel-margin comics-panel-margin-top comics-panel-padding-less comics-related-wrapper comic-rows-wrapper">
      <h3 style="text-align: center; color: #d9d9d9;"><span style="vertical-align: middle; margin-top: -4px; margin-right: 8px; font-size: 28px; color: crimson;" class="material-icons">fiber_new</span>最新上傳</h3>
      @foreach ($newest as $comic)
        @include('comic.card')
      @endforeach
  </div>

  <div style="margin-top: 6px; margin-bottom: -27px" class="search-pagination hidden-xs">{!! $newest->appends(request()->query())->links() !!}</div>
  <div style="margin-top: -10px; margin-bottom: -30px" class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $newest->appends(request()->query())->onEachSide(1)->links() !!}</div>

  @include('ads.comics-banner-juicyads')

  <script>
    var urlParams = new URLSearchParams(window.location.search);
    // $(".mobile-search-pagination .pagination .disabled").addClass('hidden-xs');
    if (urlParams.has('page') && urlParams.get('page') > 2) {
      $(".mobile-search-pagination .pagination .page-item:nth-child(3)").addClass('hidden');
    }
    if (urlParams.has('page') && urlParams.get('page') < {{ $newest->lastPage() }} - 1) {
      $(".mobile-search-pagination .pagination .page-item:nth-last-child(3)").addClass('hidden');
    }
  </script>
</div>

@endsection
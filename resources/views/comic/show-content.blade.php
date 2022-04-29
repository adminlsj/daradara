@extends('layouts.app')

@section('head')
    @parent
    @include('comic.content-head')
@endsection

@section('nav')
  @include('nav.comic')
@endsection

@section('content')

@include('ads.comics-banner-exoclick')

<div>
  @include('comic.show-content-nav')

  <div id="comic-content-wrapper" style="text-align: center; width: 100%;">
    <img id="current-page-image" src="{{ $prefix }}{{ $is_nhentai ? $page : App\Comic::addZerosToPage($page - 1) }}.{{ App\Nhentai::$parseExt[$comic->extensions[$page - 1]] }}" data-extension="{{ $comic->extension }}" data-prefix="{{ $prefix }}">

    <script>
        @if ($comic->pages - $page > 1)
          var image1 = new Image();
          image1.src = '{{ $prefix }}{{ $is_nhentai ? $page + 1 : App\Comic::addZerosToPage($page) }}.{{ App\Nhentai::$parseExt[$comic->extensions[$page + 0]] }}';
        @endif

        @if ($comic->pages - $page > 2)
          var image2 = new Image();
          image2.src = '{{ $prefix }}{{ $is_nhentai ? $page + 2 : App\Comic::addZerosToPage($page + 1) }}.{{ App\Nhentai::$parseExt[$comic->extensions[$page + 1]] }}';
        @endif

        @if ($comic->pages - $page > 3)
          var image3 = new Image();
          image3.src = '{{ $prefix }}{{ $is_nhentai ? $page + 3 : App\Comic::addZerosToPage($page + 2) }}.{{ App\Nhentai::$parseExt[$comic->extensions[$page + 2]] }}';
        @endif

        var extensions = document.createElement('textarea');
        extensions.innerHTML = '{{ $extensions }}';
        window.extensions = JSON.parse(extensions.value);
    </script>
  </div>

  @include('comic.show-content-nav')
</div>

@include('ads.comics-banner-juicyads')

@endsection
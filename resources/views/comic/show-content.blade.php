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

<!-- <div class="comics-banner-ads">
  <div class="hidden-xs" style="display: flex; justify-content: center; align-items: center;">
    <iframe width="728px" height="90px" style="display:block" marginWidth="0" marginHeight="0" frameBorder="no" src="https://creative.kbnmnl.com/widgets/v4/Universal?campaignId=728x90&modelPageOption=model&tag=girls%2Fchinese%2Cgirls%2Fjapanese&thumbsMargin=5&hideButton=1&hideTitle=1&userId=68266da2436a81581f441c04a73d1525467dff2da85808235979b437cff6f852&quality=240p&autoplay=all&autoplayForce=1"></iframe>
  </div>
  <span class="hidden-sm hidden-md hidden-lg" style="display: flex; justify-content: center; align-items: center;">
    <iframe width="300px" height="100px" style="display:block" marginWidth="0" marginHeight="0" frameBorder="no" src="https://creative.kbnmnl.com/widgets/v4/Universal?campaignId=300x100&modelPageOption=model&tag=girls%2Fchinese%2Cgirls%2Fjapanese&thumbsMargin=5&hideButton=1&hideTitle=1&userId=68266da2436a81581f441c04a73d1525467dff2da85808235979b437cff6f852&quality=240p&autoplay=all&autoplayForce=1"></iframe>
  </span>
</div> -->

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
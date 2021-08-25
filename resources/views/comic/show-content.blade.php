@extends('layouts.app')

@section('nav')
  <span class="comics-nav">
    @include('nav.main')
  </span>
@endsection

@section('content')

@include('ads.comics-banner-exoclick')

<div>
  @include('comic.show-content-nav')

  <div id="comic-content-wrapper" style="text-align: center; width: 100%;">
    <img id="current-page-image" src="https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/{{ $page }}.{{ App\Nhentai::$parseExt[$comic->extensions[$page - 1]] }}" data-extension="{{ $comic->extension }}">

    <script>
        var image1 = new Image();
        image1.src = 'https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/{{ $page + 1 }}.{{ App\Nhentai::$parseExt[$comic->extensions[$page + 0]] }}';

        var image2 = new Image();
        image2.src = 'https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/{{ $page + 2 }}.{{ App\Nhentai::$parseExt[$comic->extensions[$page + 1]] }}';

        var image3 = new Image();
        image3.src = 'https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/{{ $page + 3 }}.{{ App\Nhentai::$parseExt[$comic->extensions[$page + 2]] }}';

        var extensions = document.createElement('textarea');
        extensions.innerHTML = '{{ $extensions }}';
        window.extensions = JSON.parse(extensions.value);
    </script>
  </div>

  @include('comic.show-content-nav')
</div>

@include('ads.comics-banner-juicyads')

@endsection
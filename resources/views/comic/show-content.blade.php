@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')
<div>
  @include('comic.show-content-nav')

  <div id="comic-content-wrapper" style="text-align: center;">
    <img id="current-page-image" style="height: calc(100vh - 38px);" src="https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/{{ $page }}.jpg">

    <script>
      for (i = 1; i <= 5; i++) {
        var page = parseInt({{ $page }});
        var image = new Image();
        image.src = 'https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/' + (page + i)  + '.jpg';
      }
    </script>
  </div>

  @include('comic.show-content-nav')
</div>
@endsection
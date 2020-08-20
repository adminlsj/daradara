@extends('layouts.app')

@section('content')

  @if ($video->outsource)
    <div style="background-color: black; background-image: url('https://i.imgur.com/wgOXAy6.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px; height: 100vh;">
        <iframe src="{!! $video->sd !!}" style="border: 0; overflow: hidden; height: 100vh; width: 100%" allow="autoplay" allowfullscreen></iframe>
    </div>

  @else
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.css">
    <div id="dplayer" style="height: 100vh;"></div>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/flv.js/dist/flv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.js"></script>

    <script>
      const dp = new DPlayer({
        container: document.getElementById('dplayer'),
        autoplay: true,
        theme: '#FF0000',
        preload: 'auto',
        volume: 0.7,
        video: {
          url: '{!! $video->sd !!}',
        },
      });
    </script>
  @endif

@endsection
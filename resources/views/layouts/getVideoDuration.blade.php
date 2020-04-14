@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
  <div style="text-align: center; margin-top: 50px;"><h4>LOADING...</h4></div>
  <video style="display: none;" id="video_player" width="320" height="240" controls>
    <source src="{!! $video->source() !!}" type="video/mp4">
  </video>
  <div id="meta"></div>

  <script>
    var myVideoPlayer = document.getElementById('video_player');
    meta = document.getElementById('meta');

    myVideoPlayer.addEventListener('loadedmetadata', function () {
        var duration = myVideoPlayer.duration;
        $.ajax({
           type:'GET',
           url:'/videoDurationUpdate',
           data: {video: {{ $video->id }}, dura: duration.toFixed(0)},
           success: function(data){
             window.location = "/singleNewCreate";
           },
           error: function(xhr, ajaxOptions, thrownError){
             $("#meta").html('error');
           }
        });
    });
  </script>

@endsection
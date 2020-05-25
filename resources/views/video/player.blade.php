@if (!$video->outsource || strpos($video->sd, "instagram.com") !== FALSE || $is_mobile && strpos($video->sd, "player.bilibili.com") !== FALSE )
  <div class="aspect-ratio" style="background-color: black; background-image: url('https://i.imgur.com/TcZjkZa.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px;">
      <iframe src="{!! $video->source() !!}" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>
  </div>

@else
  <div class="aspect-ratio" style="background-color: black; background-image: url('https://i.imgur.com/TcZjkZa.gif'); background-position: center; background-repeat: no-repeat; background-size: 50px;">
      <iframe src="{!! $video->outsource() !!}" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>
  </div>

@endif